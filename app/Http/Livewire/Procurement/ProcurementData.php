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

class ProcurementData extends Component
{
    use WithFileUploads;

    // table procurement
    public $procurementCode, $userId, $supplierId, $procurementTypeId, $procurementDescription, $procurementSignatureUser, $procurementDate, $totalPrice, $status;
    // table procurement details
    public $procurementId, $productId, $description, $unitPrice, $procurementDetails;

    // data supplier and procurement type
    public $dataSupplier, $dataProcurementType;

    // data details
    public $productName, $supplierName, $procurementTypeName, $userName, $quantity, $inventoryImageUrl;

    // for view procurement
    public $search;
    public $isModalOpen = 0;
    public $isDoneModalOpen = 0;
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
                'description' => '',
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
                'description' => '',
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
            'procurementSignatureUser' => 'required'
        ]);

        
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
            'status' => 0,
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
                'description' => $value['description'],
                'unitPrice' => $value['unitPrice'],
                'quantity' => $value['quantity'],
                'imageUrl' => $images.'.webp',
            ]);
        }

        if (Auth::user()->roles == 'USER') {
            if ($this->totalPrice <= 5000000) {
                InventoryProcurementApproval::create([
                    'procurementId' => $procurementMaster->id,
                    'userId' => Auth::user()->parentUserId,
                    'status' => 'WAITING',
                    'comment' => null,
                    'signature' => null,
                ]);
            } else {
                $cekUser = User::findOrFail(Auth::user()->parentUserId);
                // dd($cekUser);
                $dataUserApproval = [
                    [
                        'procurementId' => $procurementMaster->id,
                        'userId' => $cekUser->id,
                        'status' => 'WAITING',
                        'comment' => null,
                        'signature' => null,
                        'deleted_at' => null,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'procurementId' => $procurementMaster->id,
                        'userId' => $cekUser->parentUserId,
                        'status' => 'WAITING',
                        'comment' => null,
                        'signature' => null,
                        'deleted_at' => null,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]
                ];

                InventoryProcurementApproval::insert($dataUserApproval);
            }
        }

        alert()->success('SuccessAlert','Procurement has been created successfully.');

        $this->closeModal();
        // $this->resetProcurementForm();
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
        $this->procurementDetails = $procurementDetails->procurementDetails->join('products', 'products.id', '=', $procurementDetails->procurementDetails.'productId');

        $this->procurementDetails = [$procurementDetails->procurementDetails];
        $this->openDetailModal();
    }

    public function doneProcurement($id)
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
        $this->procurementDate = $procurementDetails->procurementDate;
        $this->totalPrice = $procurementDetails->totalPrice;
        $this->status = $procurementDetails->status;

        // join product and procurement detail
        $this->procurementDetails = $procurementDetails->procurementDetails->join('products', 'products.id', '=', $procurementDetails->procurementDetails.'productId');

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
            'status' => 1,
        ]);

        foreach ($this->procurementDetails as $key => $value) {
            // dd($value[0]);
            // dd($this->supplierId);
            ProductInventory::create([
                'productId' => $value[0]['productId'],
                'purchasingNumber' => $this->procurementCode,
                'registeredDate' => $this->procurementDate,
                'yearOfEntry' => Carbon::now()->parse()->format('Y-m-d'),
                'yearOfUse' => Carbon::now()->parse()->format('Y-m-d'),
                'serialNumber' => $value[0]['description'],
                'yearOfEnd' => Carbon::now()->addYears(5)->parse()->format('Y-m-d'),
                'sertificateNumber' => $value[0]['description'].'-'.Carbon::now()->parse()->format('Y-m-d'),
                'sertificateMaker' => Auth::user()->id,
                'productOrigin' => $this->supplierId,
                'productPrice' => $value[0]['unitPrice'],
                'productDescription' => $this->procurementDescription,
                'inventoryImageUrl' => $value[0]['imageUrl'],
                // 'inventoryImageUrl' => $images.'.webp',
            ]);

            $productData = Products::findOrFail($value[0]['productId']);
            // dd($productData['qty']);
            $productData->update([
                'qty' => $productData['qty'] + $value[0]['quantity'],
            ]);
        }

        alert()->success('SuccessAlert','Product inventory has been claimed successfully.');

        $this->isDoneModalOpen = false;
    }
}
