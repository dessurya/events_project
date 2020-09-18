<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href=" {{ asset('vendors/overlayScrollbars/css/OverlayScrollbars.min.css')}} ">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/adminlte-dist/css/adminlte.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/pnotify/pnotify.custom.min.css') }}">
<style type="text/css">
    .hide{
        display :none;
    }

    table.selected-table tbody tr{
        cursor: pointer
    }

    table.selected-table tbody tr.selected{
        background-color: #aab7d1;
    }
    
    table .icon{
        height: 20px;
    }
    .table.table-head-fixed thead tr th{
        min-width : 150px !important;
    }
    /* loading page */
        #loading-page{
            position: fixed;
            top: 0;
            z-index: 99999;
            width: 100vw;
            height: 100vh;
            background-color: rgba(112,112,112,.4);
            transition: all 1.51s;
        }
        #loading-page .dis-table .row .cel{
            text-align: center;
            width: 100%;
            height: 100vh;
        }
    /* loading page */
</style>