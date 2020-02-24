<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta property="og:locale" content="ar_AR">
        <script>
            window.laravel = {csrfToken: '<?php echo e(csrf_token()); ?>'}
        </script>
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
        <!-- <script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.js"></script> -->
        <title>The Book</title>
        <div>
    </div>
 
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

       
    </head>
    <style>
    body{
        direction: rtl;
        text-align: right;
    }
    .spinner-box{
        width: 62px !important;
        position: sticky;
        top: 32%;
    }
    .hide{
        display: none;
    }
    body{
        /* zoom: .8; */
        /* zoom: 1.30; */
        -moz-transform: scale(0.5);
    }
    
    </style>
    <body>
        <div id="app"> 
            <div class="container-fluid">
                <!-- <suras-list></suras-list> -->
                <board></board>
                <!-- <calculate-box></calculate-box> -->
                <!-- <suras-list></suras-list> -->
                <!-- <vuetify></vuetify> -->
            </div> 
        </div>
        <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
        <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    </body>
</html>
