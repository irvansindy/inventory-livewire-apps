<?php

namespace App\Http\Livewire\Procurement;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use App\Models\Suppliers;
use App\Models\Products;
use App\Models\InventoryProcurement;
use App\Models\InventoryProcurementDetails;
use App\Models\InventoryProcurementApproval;
use App\Models\ProcurementType;
use App\Models\ProductInventory;
use Carbon\Carbon;
use Image;
use Livewire\WithFileUploads;
use Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class ProcurementData extends Component
{
    use WithFileUploads;

    // table procurement
    public $procurementCode, $userId, $supplierId, $procurementTypeId, $procurementDescription, $procurementSignatureUser, $procurementDate, $totalPrice, $status;
    // table procurement details
    public $procurementId, $productId, $description, $unitPrice, $procurementDetails, $inventoryName, $specification;

    // data supplier and procurement type
    public $dataSupplier, $dataProcurementType;

    // data details
    public $productName, $supplierName, $procurementTypeName, $userName, $quantity, $inventoryImageUrl;

    // data approval
    public $commentApproval, $statusApproval, $dataApproval, $approvalId;

    // for view procurement
    public $search;
    public $isModalOpen = 0;
    public $isDoneModalOpen = 0;
    public $isApproveModalOpen = 0;
    public $isDetailApproveModalOpen = 0;
    public $limitPerPage = 10;
    protected $queryString = ['search'=> ['except' => '']];
    protected $listeners = [
        'procurement' => 'procurementPostData'
    ];

    public $allProducts = [];
    public $orderProcurements = [];

    public function mount() {
        $this->allProducts = Products::all();
        $this->orderProcurements = [
            [
                'productId' => '',
                'inventoryName' => '',
                'specification' => '',
                'unitPrice' => '',
                'quantity' => '',
                'inventoryImageUrl' => ''
            ]
        ];
    }

    // for view procurement
    public $isDetailProcurement = 0;

    public function addProductProcurement()
    {
        $this->orderProcurements[] = [
            [
                'productId' => '',
                'inventoryName' => '',
                'specification' => '',
                'unitPrice' => '',
                'quantity' => '',
                'inventoryImageUrl' => ''
            ]
        ];
    }

    public function removeProductProcurement($index)
    {   
        unset($this->orderProcurements[$index]);
        array_values($this->orderProcurements);
    }

    public function procurementPostData() {
        $this->limitPerPage = $this->limitPerPage+6;
    }

    public function openModal() {
        $this->isModalOpen = true;
    }

    public function closeModal() {
        $this->isModalOpen = false;
        $this->isDetailProcurement = false;
        $this->resetProcurementForm();
    }

    public function openDetailModal()
    {
        $this->isDetailProcurement = true;
    }

    public function resetProcurementForm()
    {
        $this->procurementCode = '';
        $this->userId = '';
        $this->supplierId = '';
        $this->procurementTypeId = '';
        $this->procurementDescription = '';
        $this->procurementDate = '';
        $this->totalPrice = '';
        $this->status = '';
        $this->procurementId = '';
        $this->productId = '';
        $this->description = '';
        $this->unitPrice = '';
        $this->procurementDetails = '';
        $this->orderProcurements = [
            [
                'productId' => '',
                'description' => '',
                'unitPrice' => 0,
                'quantity' => 1,
            ]
        ];
    }

    public function addProcurement() 
    {
        $this->dataSupplier = Suppliers::all();
        $this->dataProcurementType = ProcurementType::all();
        $this->openModal();
    }

    public function storeProcurement()
    {
        $this->validate([
                'supplierId' => 'required',
                'procurementTypeId' => 'required',
                'procurementDescription' => 'required',
                'procurementDate' => 'required',
                'procurementSignatureUser' => 'required',
                'productId.*' => 'required',
                'inventoryName.*' => 'required',
                'specification.*' => 'required',
                'unitPrice.*' => 'required|numeric',
                'quantity.*' => 'required|numeric',
                'inventoryImageUrl.*' => 'required|image|mimes:jpeg,png,jpg,svg|max:4096',
            ], [
                'supplierId.required' => 'Supplier is required',
                'procurementTypeId.required' => 'Procurement Type is required',
                'procurementDescription.required' => 'Description is required',
                'procurementDate.required' => 'Date is required',
                'procurementSignatureUser.required' => 'Signature User is required',
                'productId.*.required' => 'Product is required',
                'inventoryName.*.required' => 'Product Name is required',
                'specification.*.required' => 'Product Name is required',
                'unitPrice.*.required' => 'Unit Price is required',
                'quantity.*.required' => 'Quantity is required',
                'inventoryImageUrl.*.required' => 'Image is required',
            ]
        );

        // store signature
        $folderPath = public_path('upload/images/signature/');

        $image_parts = explode(";base64,", $this->procurementSignatureUser);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $fileToFolder = $folderPath . date('ymd-hi') . '.'.$image_type;

        $fileToDatabase = date('ymd-hi') . '.'.$image_type;
        
        file_put_contents($fileToFolder, $image_base64);
        
        $this->totalPrice = $this->orderProcurements[0]['unitPrice'] * $this->orderProcurements[0]['quantity'];

        $procurementMaster = InventoryProcurement::create([
            'userId' => Auth::user()->id,
            'supplierId' => $this->supplierId,
            'procurementTypeId' => $this->procurementTypeId,
            'procurementDescription' => $this->procurementDescription,
            'procurementSignatureUser' => $fileToDatabase,
            'procurementDate' => $this->procurementDate,
            'totalPrice' => $this->totalPrice,
            'status' => 'PENDING',
        ]);

        foreach ($this->orderProcurements as $procurementDetail => $value)
        {
            $images = rand().".".$value['inventoryImageUrl']->getClientOriginalExtension();

            // for real images
            $value['inventoryImageUrl']->storeAs('real_images', $images, 'path');
            
            // for webp images
            $imageToWebp = Image::make($value['inventoryImageUrl'])->encode('webp', 80)
            ->save("upload/images/webp/$images.webp", 80);

            InventoryProcurementDetails::create([
                'procurementId' => $procurementMaster->id,
                'productId' => $value['productId'],
                'inventoryName' => $value['inventoryName'],
                'specification' => $value['specification'],
                'unitPrice' => $value['unitPrice'],
                'quantity' => $value['quantity'],
                'imageUrl' => $images.'.webp',
            ]);
        }

        if(Auth::user()->roles == 'USER') {
            InventoryProcurementApproval::create([
                'procurementId' => $procurementMaster->id,
                'userId' => Auth::user()->parentUserId,
                'status' => 'WAITING',
                'comment' => null,
                'signature' => null,
            ]);
        } elseif(Auth::user()->roles == 'ADMIN') {
            InventoryProcurementApproval::create([
                'procurementId' => $procurementMaster->id,
                'userId' => Auth::user()->id,
                'status' => 'WAITING',
                'comment' => null,
                'signature' => null,
            ]);
        }
        alert()->success('SuccessAlert','Procurement has been created successfully.');

        $this->closeModal();
    }

    public function render()
    {
        // $procurements = InventoryProcurement::latest()->paginate($this->limitPerPage);
        $procurements = InventoryProcurement::with('supplier')
        ->with('procurementType')
        ->with('user')
        ->latest()
        ->paginate($this->limitPerPage);
        
        // dd($procurements);

        if($this->search !== NULL) {
            $procurements = InventoryProcurement::with([
                'user',
                'products',
                'supplier',
                'procurementType',
            ])->whereHas('user', function($query) {
                $query->where('username', 'like', '%'.$this->search.'%');
            })->orWhereHas('supplier', function($query) {
                $query->where('supplierName', 'like', '%'.$this->search.'%');
            })->orWhereHas('procurementType', function($query) {
                $query->where('procurementTypeName', 'like', '%'.$this->search.'%');
            })->orWhere('totalPrice', 'like', '%'.$this->search.'%')
            ->orWhere('status', 'like', '%'.$this->search.'%')
            ->orWhere('procurementCode', 'like', '%'.$this->search.'%');

            $procurements = $procurements->paginate($this->limitPerPage);
        }
        
        $this->emit('procurementPostData');
        $this->dataSupplier = Suppliers::all();
        $this->dataProcurementType = ProcurementType::all();
        
        return view('livewire.procurement.procurement-data', [
            'procurements' => $procurements
        ]);
    }

    public function detailProcurement($id)
    {
        $procurementDetails = InventoryProcurement::with([
            'user',
            'products',
            'supplier',
            'procurementType',
            'procurementDetails'
        ])->findOrFail($id);

        $this->procurementId = $procurementDetails->id;
        $this->procurementCode = $procurementDetails->procurementCode;
        $this->userName = $procurementDetails->user->name;
        $this->supplierName = $procurementDetails->supplier->supplierName;
        $this->supplierId = $procurementDetails->supplier->id;
        $this->procurementTypeName = $procurementDetails->procurementType->procurementTypeName;
        $this->procurementDescription = $procurementDetails->procurementDescription;
        $this->procurementSignatureUser = $procurementDetails->procurementSignatureUser;
        $this->procurementDate = $procurementDetails->procurementDate;
        $this->totalPrice = $procurementDetails->totalPrice;
        $this->status = $procurementDetails->status;

        // join product and procurement detail
        $listProcurementDetails = InventoryProcurementDetails::with([
            'procurement',
            'product'
        ])->where('procurementId', $id)->get();

        $this->procurementDetails = $listProcurementDetails;
        $this->openDetailModal();
    }

    public function doneProcurement($id)
    {
        Gate::authorize('admin');
        $procurementDetails = InventoryProcurement::with([
            'user',
            'products',
            'supplier',
            'procurementType',
            'procurementDetails'
        ])->findOrFail($id);

        $this->procurementId = $procurementDetails->id;
        $this->procurementCode = $procurementDetails->procurementCode;
        $this->userName = $procurementDetails->user->name;
        $this->supplierName = $procurementDetails->supplier->supplierName;
        $this->supplierId = $procurementDetails->supplier->id;
        $this->procurementTypeName = $procurementDetails->procurementType->procurementTypeName;
        $this->procurementDescription = $procurementDetails->procurementDescription;
        $this->procurementDate = $procurementDetails->procurementDate;
        $this->totalPrice = $procurementDetails->totalPrice;
        $this->status = $procurementDetails->status;

        // join product and procurement detail
        // $this->procurementDetails = $procurementDetails->procurementDetails->join('products', 'products.id', '=', $procurementDetails->procurementDetails.'productId');

        $this->procurementDetails = [$procurementDetails->procurementDetails];
        $this->isDoneModalOpen = true;
    }

    public function cancelProcurement()
    {
        $this->isDoneModalOpen = false;
    }

    public function storeProcurementProductToInventory()
    {
        // $this->validate([
        //     'supplierId' => 'required',
        //     'procurementTypeId' => 'required',
        //     'procurementDescription' => 'required',
        //     'procurementDate' => 'required'
        // ]);

        $procurement = InventoryProcurement::findOrFail($this->procurementId);

        $procurement->update([
            'status' => 'CLAIM',
        ]);

        foreach ($this->procurementDetails as $key => $value) {
            ProductInventory::create([
                'productId' => $value[0]['productId'],
                'inventoryName' => $value[0]['inventoryName'],
                'specification' => $value[0]['specification'],
                'purchasingNumber' => $this->procurementCode,
                'registeredDate' => $this->procurementDate,
                'yearOfEntry' => Carbon::now()->parse()->format('Y-m-d'),
                'yearOfUse' => Carbon::now()->parse()->format('Y-m-d'),
                'serialNumber' => $value[0]['inventoryName'],
                'yearOfEnd' => Carbon::now()->addYears(5)->parse()->format('Y-m-d'),
                'sertificateNumber' => $value[0]['inventoryName'].'-'.Carbon::now()->parse()->format('Y-m-d'),
                'sertificateMaker' => Auth::user()->id,
                'productOrigin' => $this->supplierId,
                'productPrice' => $value[0]['unitPrice'],
                'productDescription' => $this->procurementDescription,
                'productStatus' => 'AVAILABLE',
                'officeId' => 1,
                'inventoryImageUrl' => $value[0]['imageUrl'],
                // 'inventoryImageUrl' => $images.'.webp',
            ]);

            $productData = Products::findOrFail($value[0]['productId']);
            $productData->update([
                'qty' => $productData['qty'] + $value[0]['quantity'],
            ]);
        }

        alert()->success('SuccessAlert','Product inventory has been claimed successfully.');

        $this->isDoneModalOpen = false;
    }

    public function approveProcurement($id)
    {
        Gate::authorize('admin');
        // dd($id);
        $procurementApprovalDetails = InventoryProcurement::with([
            'user',
            'products',
            'supplier',
            'procurementType',
            'procurementDetails',
            'procurementApprovals'
        ])->findOrFail($id);

        $listProcurementDetails = InventoryProcurementDetails::with([
            'procurement',
            'product'
        ])->where('procurementId', $id)->get();

        $listApproval = InventoryProcurementApproval::with([
            'procurement',
            'user',
        ])->where('procurementId', $id)->get();

        $this->procurementId = $procurementApprovalDetails->id;
        $this->procurementCode = $procurementApprovalDetails->procurementCode;
        $this->userName = $procurementApprovalDetails->user->name;
        $this->supplierName = $procurementApprovalDetails->supplier->supplierName;
        $this->supplierId = $procurementApprovalDetails->supplier->id;
        $this->procurementTypeName = $procurementApprovalDetails->procurementType->procurementTypeName;
        $this->procurementDescription = $procurementApprovalDetails->procurementDescription;
        $this->procurementSignatureUser = $procurementApprovalDetails->procurementSignatureUser;
        $this->procurementDate = $procurementApprovalDetails->procurementDate;
        $this->totalPrice = $procurementApprovalDetails->totalPrice;
        $this->status = $procurementApprovalDetails->status;

        // data product and procurement detail
        $this->procurementDetails = $listProcurementDetails;
        
        // data procurement master and procuremens approval
        $this->dataApproval = $listApproval;

        $this->isApproveModalOpen = true;
    }

    public function cancelApproval()
    {
        $this->isApproveModalOpen = false;
        $this->isDetailApproveModalOpen = false;

    }

    public function updateApprovalProcurement()
    {
        // $this->validate([
        //     'commentApproval' => 'required',
        //     'procurementSignatureUser.*' => 'required',
        // ]);
        // dd($this->dataApproval);
        // dd($this->dataApproval[0]['user']);
        // if (Auth::user()->id == $this->dataApproval->user->id) {
        //     dd('success');
        // }

        // store signature
        $folderPath = public_path('upload/images/signature/');

        $image_parts = explode(";base64,", $this->procurementSignatureUser);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $fileToFolder = $folderPath . date('ymd-hi') . '.'.$image_type;

        $fileToDatabase = date('ymd-hi') . '.'.$image_type;
        
        file_put_contents($fileToFolder, $image_base64);

        foreach ($this->dataApproval as $key => $approvalList) {
            if (Auth::user()->id = $approvalList->user->id && $approvalList->procurementId = $this->procurementId) {
                if($approvalList->status == 'WAITING')
                {
                    $approvalList->where('userId', Auth::user()->id)
                    ->update([
                        'comment' => $this->commentApproval,
                        'signature' => $this->procurementSignatureUser,
                        'status' => 'APPROVE',
                    ]);

                    alert()->success('SuccessAlert','Procurement has been approved successfully.');
                } else {
                    alert()->warning('WarningAlert','Procurement approval has been error.');
                }
            } else {
                alert()->warning('WarningAlert','Procurement approval has been error.');
            }
        }

        $this->isApproveModalOpen = false;

    }

    public function detailApproval($id)
    {
        // authorize permission
        Gate::authorize('admin');

        // get data detail approval
        $detailApprovalProcurement = InventoryProcurementApproval::with([
            'procurement'
        ])
        ->where('userId', Auth::user()->id)
        ->where('procurementId', $id)
        // ->where('status', 'WAITING')
        ->get();
        // dd($detailApprovalProcurement);
        if($detailApprovalProcurement[0]->status === 'WAITING') {
            // get product detail
            $listProcurementDetails = InventoryProcurementDetails::with([
                'procurement',
                'product'
            ])->where('procurementId', $id)->get();
            // data binding
            $this->approvalId = $detailApprovalProcurement[0]->id;
            $this->procurementDetails = $listProcurementDetails;
            $this->procurementId = $detailApprovalProcurement[0]->procurement->id;
            $this->procurementCode = $detailApprovalProcurement[0]->procurement->procurementCode;
            $this->procurementDescription = $detailApprovalProcurement[0]->procurement->procurementDescription;
            $this->procurementSignatureUser = $detailApprovalProcurement[0]->procurement->procurementSignatureUser;
            $this->procurementDate = $detailApprovalProcurement[0]->procurement->procurementDate;
            $this->totalPrice = $detailApprovalProcurement[0]->procurement->totalPrice;
            $this->status = $detailApprovalProcurement[0]->procurement->status;
            
            $this->isDetailApproveModalOpen = true;
        } else {
            alert()->warning('WarningAlert','Procurement has been approved.');
        }
    }

    public function storeAndUpdateStaggingApprovalProcurement()
    {
        Gate::authorize('admin');
        
        $this->validate([
            'commentApproval' => 'required|string',
            'procurementSignatureUser' => 'required',
        ]);

        // store signature
        $folderPath = public_path('upload/images/signature/');

        $image_parts = explode(";base64,", $this->procurementSignatureUser);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $fileToFolder = $folderPath . date('ymd-hi') . '.'.$image_type;

        $fileToDatabase = date('ymd-hi') . '.'.$image_type;

        // check data master procurement and procurement approval
        $checkProcurement = InventoryProcurement::findOrfail($this->procurementId);
        $checkApproval = InventoryProcurementApproval::findOrfail($this->approvalId);
        // dd([$checkProcurement, $checkApproval]);
        if($checkProcurement->status == 'PENDING' && $checkProcurement->totalPrice <= 5000000) {
            // update in master procurement
            $checkProcurement->update([
                'status' => 'ON PROGRESS',
            ]);

            // update in procurement approval
            $checkApproval->update([
                'comment' => $this->commentApproval,
                'signature' => $fileToDatabase,
                'status' => 'APPROVE',
            ]);

            alert()->success('SuccessAlert','Procurement has been approved successfully.');
        } else {
            if(Auth::user()->roles == 'ADMIN') {
                // update in master procurement
                $checkProcurement->update([
                    'status' => 'ON PROGRESS',
                ]);

                // update in procurement approval
                $checkApproval->update([
                    'comment' => $this->commentApproval,
                    'signature' => $fileToDatabase,
                    'status' => 'FORWARD',
                ]);
    
                // $checkUser = User::findOrfail($checkApproval->userId);
                InventoryProcurementApproval::create([
                    'procurementId' => $this->procurementId,
                    'userId' => Auth::user()->parentUserId,
                    'status' => 'WAITING',
                    'comment' => null,
                    'signature' => null,
                ]);
    
                alert()->success('SuccessAlert','Procurement has been forwarded successfully.');
            } elseif(Auth::user()->roles == 'SUPERADMIN') {
                // update in master procurement
                $checkProcurement->update([
                    'status' => 'ON PROGRESS',
                ]);

                // update in procurement approval
                $checkApproval->update([
                    'comment' => $this->commentApproval,
                    'signature' => $fileToDatabase,
                    'status' => 'APPROVE',
                ]);

                alert()->success('SuccessAlert','Procurement has been approved successfully.');
            }
        }
        $this->isDetailApproveModalOpen = false;
    }

    public function printProcurement($id)
    {
        Gate::authorize('admin');
        
        // 'procurementDetails' => function($query) {
        //     $query->with([
        //         'product'
        //     ]);
        // },
        // 'procurementApprovals' => function($query) {
        //     $query->with([
        //         'user'
        //     ]);
        // },
        $printPocurement = InventoryProcurement::with([
            'user',
        ])->findOrFail($id);

        $printPocurementDetails = InventoryProcurementDetails::with([
            'procurement',
            'product'
        ])->where('procurementId', $id)->get();

        $printPocurementApproval = InventoryProcurementApproval::with([
            'procurement',
            'user'
        ])->where('procurementId', $id)->get();
        
        $pdf = PDF::loadView('livewire.procurement.report-procurement', 
        [
            'printPocurement' => $printPocurement,
            'printPocurementDetails' => $printPocurementDetails,
            'printPocurementApproval' => $printPocurementApproval
        ])->setPaper('a4', 'portrait')->output();

        // return response()->streamDownload(fn() => print($pdf), 'report-procurement.pdf');
        return response()->streamDownload(fn() => print($pdf), 'report-procurement.pdf', [], 'inline');
    }
}
