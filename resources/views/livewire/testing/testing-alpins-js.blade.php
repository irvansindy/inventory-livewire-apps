<div>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>

    <style>
        .kbw-signature { width: 100%; height: 200px;}
        #sig canvas{
            width: 100% !important;
            height: auto;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-3 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h5>Signature Pad</h5>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success  alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">×</button>  
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        <form method="POST">
                            @csrf
                            <div class="col-md-12">
                                <label class="" for="">Signature:</label>
                                <br/>
                                <div id="sig" class="rounded-lg border border-dark shadow p-1 mb-5"></div>
                                <br/>
                                <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                                <textarea id="signatureApproval" name="signed" style="display: none"></textarea>
                            </div>
                            <br/>
                            <button class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var sig = $('#sig').signature({syncField: '#signatureApproval', syncFormat: 'PNG'});
        $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signatureApproval").val('');
        });
    </script>
</div>