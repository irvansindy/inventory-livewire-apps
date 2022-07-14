<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Procurement</title>
        <script src="https://cdn.tailwindcss.com"></script>

        <style type="text/css">
            @page {
                margin: 0px;
            }
            body {
                margin: 0px;
            }
            * {
                font-family: Verdana, Arial, sans-serif;
            }
            a {
                color: #fff;
                text-decoration: none;
            }
            table {
                font-size: x-small;
            }
            tfoot tr td {
                font-weight: bold;
                font-size: x-small;
            }
            .invoice table {
                margin: 15px;
            }
            .invoice h3 {
                margin-left: 15px;
            }
            .information {
                background-color: #60A7A6;
                color: #FFF;
            }
            .information .logo {
                margin: 5px;
            }
            .information table {
                padding: 10px;
            }
            .header-table {
                border-collapse: collapse;
                width: 100%;
            }
            .procurement-id {
                color: #A10035;
                margin: 20px;
            }

            .table-item-procurement {
                border: 1px solid;
                width: 100%;
            }
        </style>

    </head>
    <body>

    <div class="information">
        <table width="100%">
            <tr>
                <td align="left" style="width: 40%;">
                    <h3>John Doe</h3>
                    <pre>
    Street 15
    123456 City
    United Kingdom
    <br /><br />
    Date: 2018-01-01
    Identifier: #uniquehash
    Status: Paid
    </pre>


                </td>
                <td align="center">
                    <img src="/path/to/logo.png" alt="Logo" width="64" class="logo"/>
                </td>
                <td align="right" style="width: 40%;">

                    <h3>CompanyName</h3>
                    <pre>
                        https://company.com

                        Street 26
                        123456 City
                        United Kingdom
                    </pre>
                </td>
            </tr>

        </table>
    </div>


    <br/>

    <div class="invoice">
        {{-- <h3>{{ $printPocurement->procurementCode }}</h3> --}}
        <p class="procurement-id">
            {{ $printPocurement->procurementCode }}
        </p>
        <table class="table-item-procurement">
            <thead class="header-table">
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Number</th>
                    <th class="border px-4 py-2">Item</th>
                    <th class="border px-4 py-2">Spesification</th>
                    <th class="border px-4 py-2">User</th>
                </tr>
            </thead>
            <tbody>
                {{-- @php
                    dd($printPocurement->procurementCode);
                @endphp --}}
                @forelse ($printPocurementDetails as $itemDetail)
                @php
                    $i = 0;
                @endphp
                <tr>
                    <td class="border px-4 py-2">{{ $i +=1 }}</td>
                    <td class="border px-4 py-2">{{ $itemDetail->product->productName }}</td>
                    <td class="border px-4 py-2">{{ $itemDetail->description }}</td>
                    <td class="border px-4 py-2">{{ $printPocurement->user->name }}</td>
                </tr>
                @empty
                    <tr>
                        <td colspan="5">No data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <table class="table-auto border-separate w-full">
            <thead>
                <tr>
                    <th>Approved by</th>
                    <th>Confirmed by</th>
                    <th>Created by</th>
                </tr>
                {{-- @forelse ($printPocurementApproval as $key => $approval) --}}
                @php
                    // dd([
                        // $printPocurementApproval,
                        // $approval
                        // $key
                    // ]);
                @endphp
                <tr>
                    <td>Approved at: {{ $printPocurementApproval[1]->created_at }}</td>
                    <td>Confirmed at: {{ $printPocurementApproval[0]->created_at }}</td>
                    <td>Created at: {{ $printPocurement->created_at }}</td>
                </tr>
                {{-- @empty
                    
                @endforelse --}}
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
            <div class="overflow-hidden">
              <table class="min-w-full border text-center">
                <thead class="border-b">
                  <tr>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 border-r">
                      #
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 border-r">
                      First
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 border-r">
                      Last
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                      Handle
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="border-b">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r">1</td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap border-r">
                      Mark
                    </td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap border-r">
                      Otto
                    </td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                      @mdo
                    </td>
                  </tr>
                  <tr class="bg-white border-b">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r">2</td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap border-r">
                      Jacob
                    </td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap border-r">
                      Thornton
                    </td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                      @fat
                    </td>
                  </tr>
                  <tr class="bg-white border-b">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r">3</td>
                    <td colspan="2" class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-center border-r">
                      Larry the Bird
                    </td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                      @twitter
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    <div class="information" style="position: absolute; bottom: 0;">
        <table class="table-auto w-full">
            <tr>
                <td align="left" style="width: 50%;">
                    {{-- &copy; {{ date('Y') }} {{ config('app.url') }} - All rights reserved. --}}
                </td>
                <td align="right" style="width: 50%;">
                    PT. PRALON
                </td>
            </tr>

        </table>
    </div>
    </body>
</html>