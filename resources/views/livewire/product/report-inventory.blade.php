<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Invoice - #123</title>

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
        <h3>List Data Inventory</h3>
        <table class="table-auto w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Code</th>
                    <th class="border px-4 py-2">Product Name</th>
                    <th class="border px-4 py-2">Merk</th>
                    <th class="border px-4 py-2">Purchasing Number</th>
                    <th class="border px-4 py-2">Supplier</th>
                    <th class="border px-4 py-2">User</th>
                    <th class="border px-4 py-2">Price</th>
                    <th class="border px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($inventaries as $item)
                <tr>
                    <td class="border px-4 py-2">{{ $item->inventoryCode }}</td>
                    <td class="border px-4 py-2">{{ $item->productName }}</td>
                    <td class="border px-4 py-2">{{ $item->merk }}</td>
                    <td class="border px-4 py-2">{{ $item->purchasingNumber }}</td>
                    <td class="border px-4 py-2">{{ $item->supplierName }}</td>
                    <td class="border px-4 py-2">{{ $item->name }}</td>
                    <td class="border px-4 py-2">{{ $item->productPrice }}</td>
                    <td class="border px-4 py-2">{{ $item->productStatus }}</td>
                </tr>
                @empty
                    <tr>
                        <td colspan="8">No data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="information" style="position: absolute; bottom: 0;">
        <table class="table-auto w-full">
            <tr>
                <td align="left" style="width: 50%;">
                    &copy; {{ date('Y') }} {{ config('app.url') }} - All rights reserved.
                </td>
                <td align="right" style="width: 50%;">
                    PT. PRALON
                </td>
            </tr>

        </table>
    </div>
    </body>
</html>