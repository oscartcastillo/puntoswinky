<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Encuesta Winkycoffee</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
</head>
<body>

    <style>
        body{
            background-image: url('../img/login.png');
        }

        #grad1 {
            background-color: : #9C27B0;
            background-image: linear-gradient(120deg, #FF4081, #81D4FA)
        }

        #msform {
            text-align: center;
            position: relative;
            margin-top: 20px
        }

        #msform fieldset .form-card {
            background: white;
            border: 0 none;
            border-radius: 0px;
            box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
            padding: 20px 40px 30px 40px;
            box-sizing: border-box;
            width: 94%;
            margin: 0 3% 20px 3%;
            position: relative
        }

        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 0.5rem;
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            padding-bottom: 20px;
            position: relative
        }

        #msform fieldset:not(:first-of-type) {
            display: none
        }

        #msform fieldset .form-card {
            text-align: left;
            color: #9E9E9E
        }

        #msform input,
        #msform textarea {
            padding: 0px 8px 4px 8px;
            border: none;
            border-bottom: 1px solid #ccc;
            border-radius: 0px;
            margin-bottom: 15px;
            margin-top: 2px;
            width: 100%;
            box-sizing: border-box;
            font-family: montserrat;
            color: #2C3E50;
            font-size: 16px;
            letter-spacing: 1px
        }

        #msform input:focus,
        #msform textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: none;
            font-weight: bold;
            border-bottom: 2px solid #c2d900;
            outline-width: 0
        }

        #msform .action-button {
            width: 100px;
            background: #c2d900;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px
        }

        #msform .action-button:hover,
        #msform .action-button:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #c2d900
        }

        #msform .action-button-previous {
            width: 100px;
            background: #616161;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px
        }

        #msform .action-button-previous:hover,
        #msform .action-button-previous:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #616161
        }

        select.list-dt {
            border: none;
            outline: 0;
            border-bottom: 1px solid #ccc;
            padding: 2px 5px 3px 5px;
            margin: 2px
        }

        select.list-dt:focus {
            border-bottom: 2px solid #c2d900
        }

        .card {
            z-index: 0;
            border: none;
            border-radius: 0.5rem;
            position: relative
        }

        .fs-title {
            font-size: 25px;
            color: #2C3E50;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: left
        }

        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: lightgrey
        }

        #progressbar .active {
            color: #000000
        }

        #progressbar li {
            list-style-type: none;
            font-size: 12px;
            width: 33%;
            float: left;
            position: relative
        }

        #progressbar #account:before {
            font-family: FontAwesome;
            content: "\f023"
        }

        #progressbar #personal:before {
            font-family: FontAwesome;
            content: "\f007"
        }

        #progressbar #payment:before {
            font-family: FontAwesome;
            content: "\f09d"
        }

        #progressbar #confirm:before {
            font-family: FontAwesome;
            content: "\f00c"
        }

        #progressbar li:before {
            width: 50px;
            height: 50px;
            line-height: 45px;
            display: block;
            font-size: 18px;
            color: #ffffff;
            background: lightgray;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            padding: 2px
        }

        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: lightgray;
            position: absolute;
            left: 0;
            top: 25px;
            z-index: -1
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: #c2d900
        }

        .radio-group {
            position: relative;
            margin-bottom: 25px
        }

        .radio {
            display: inline-block;
            width: 204;
            height: 104;
            border-radius: 0;
            background: lightblue;
            box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
            box-sizing: border-box;
            cursor: pointer;
            margin: 8px 2px
        }

        .radio:hover {
            box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3)
        }

        .radio.selected {
            box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1)
        }

        .fit-image {
            width: 100%;
            object-fit: cover
        }
        @media (max-width: 600px) {
            .radios{
                display: flex;
                align-content: center;
                text-align: center;
                margin-top: 0px;
            }
            .radius {
                margin: 5px !important;
                width: 25% !important;
            }
            #msform fieldset .form-card {
                padding: 20px 15px 15px 20px;
            }
            .respues-m{
                padding: 5% 0%;
            }
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="container-fluid">
                <div class="row justify-content-center mt-0">
                    <div class="col-12 col-sm-9 col-md-10 col-lg-10 text-center p-0 mt-3 mb-2">
                        <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                            <h2><strong>Encuesta de Satisfacción</strong></h2>
                            <div id="msform">
                                {{ csrf_field() }}
                                <ul id="progressbar" class="p-0">
                                    <li class="active" id="account"><strong>Informacion Personal</strong></li>
                                    <li id="personal"><strong>Trato</strong></li>
                                    <li id="payment"><strong>Servicio</strong></li>
                                    <!--<li id="confirm"><strong>Finish</strong></li>-->
                                </ul>
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Información Personal</h2>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nombre">Nombre :</label>
                                                    <input type="text" id="nombre" class="form-control" placeholder="Escriba su nombre porfavor">
                                                    <p class="errorNombre text-center alert alert-danger" style="display: none;"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="correo">Correo :</label>
                                                    <input type="email" id="correo" class="form-control" placeholder="Escriba su correo">
                                                    <p class="errorCorreo text-center alert alert-danger" style="display: none;"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="sexo">Sexo:</label>
                                            <select id="sexo" class="custom-select">
                                                <option value="">Seleccione su sexo</option>
                                                <option value="A">Masculino</option>
                                                <option value="B">Femenino</option>
                                            </select>
                                            <p class="errorSexo text-center alert alert-danger" style="display: none;"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="edad">Edad :</label>
                                            <select id="edad" class="custom-select">
                                                <option value="">Seleccione su edad</option>
                                                <option value="A">Menor de 29 años</option>
                                                <option value="B">De 30 a 40 años</option>
                                                <option value="C">Mayor a 40 años</option>
                                            </select>
                                            <p class="errorEdad text-center alert alert-danger" style="display: none;"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="tipoperfil">Perfil :</label>
                                            <select id="tipo" class="custom-select">
                                                <option value="">Seleccion su perfil</option>
                                                @foreach ($perfiles as $perfil)
                                                    <option value="{{$perfil->id}}">{{$perfil->tipo_perfil_nombre}}</option>
                                                @endforeach
                                            </select>
                                            <p class="errorTipo text-center alert alert-danger" style="display: none;"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="sucursal">Sucursal :</label>
                                            <select id="sucursal" class="custom-select">
                                                <option value="">Seleccione la sucursal</option>
                                                @foreach ($empresas as $empresa)
                                                    <option value="{{$empresa->id}}">{{$empresa->empresa_nombre}}</option>
                                                @endforeach
                                            </select>
                                            <p class="errorSucursal text-center alert alert-danger" style="display: none;"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="nosotros">¿Como te enteraste de nosotros?</label>
                                            <select id="difusion" class="custom-select">
                                                <option value="">Selecciona alguna opcion</option>
                                                <option value="1">Redes Sociales</option>
                                                <option value="2">Ubicación</option>
                                                <option value="3">Recomendación</option>
                                                <option value="4">Revista</option>
                                                <option value="5">Otro</option>
                                            </select>
                                            <p class="errorNosotros text-center alert alert-danger" style="display: none;"></p>
                                        </div>
                                    </div>
                                    <input id="btn-personal" type="button" name="next" class="next action-button" value="Continuar"/>
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Atención</h2>
                                        <div class="d-none d-lg-block">
                                            <div class="row" style="padding: 30px 0px;">
                                                <div class="col-lg-6 ">
                                                    Preguntas
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="row p-0">
                                                        <div class="col-lg-3 text-center">Excelente</div>
                                                        <div class="col-lg-3 text-center">Bueno</div>
                                                        <div class="col-lg-3 text-center">Regular</div>
                                                        <div class="col-lg-3 text-center">Malo</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                A) ¿En general que tal fue la atención a su servicio?
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row respues-m">
                                                    <div class="col-12 col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="1" value="A" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Excelente</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-12 col-md-3 text-center">
                                                        <label class="radios">
                                                            <input  type="radio" name="1" value="B" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Bueno</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-12 col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="1" value="C" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Regular</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-12 col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="1" value="D" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Malo</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                B) La atención del cajero fue...
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row respues-m">
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="2" value="A" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Excelente</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="2" value="B" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Bueno</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="2" value="C" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Regular</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="2" value="D" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Malo</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                C) ¿Qué te parecen nuestros precios?
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="3" value="A" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Excelente</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="3" value="B" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Bueno</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="3" value="C" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Regular</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="3" value="D" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Malo</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                D) ¿Cómo calificas el sabor de nuestros platillos?
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="4" value="A" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Excelente</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="4" value="B" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Bueno</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="4" value="C" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Regular</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="4" value="D" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Malo</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                E) ¿Cómo calificas la higiene de nuestros platillos?
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="5" value="A" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Excelente</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="5" value="B" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Bueno</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="5" value="C" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Regular</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="5" value="D" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Malo</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                F) ¿El servicio de internet fue...?
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="6" value="A" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Excelente</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="6" value="B" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Bueno</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="6" value="C" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Regular</h6>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <label class="radios">
                                                            <input type="radio" name="6" value="D" required="required" class="radius">
                                                            <h6 class="d-block d-lg-none">Malo</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<input type="button" name="previous" class="previous action-button-previous" value="Previous"/>-->
                                    <input type="button" name="next" class="next action-button" value="Next Step"/>
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Servicio</h2>
                                        <!--<div class="radio-group">
                                            <div class='radio' data-value="credit">
                                                <img src="https://i.imgur.com/XzOzVHZ.jpg" width="200px" height="100px">
                                            </div>
                                            <div class='radio' data-value="paypal">
                                                <img src="https://i.imgur.com/jXjwZlj.jpg" width="200px" height="100px">
                                            </div>
                                        </div>
                                        <label class="pay">Card Holder Name*</label>
                                        <input type="text" name="holdername" placeholder=""/>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="pay">Card Number*</label>
                                                <input type="text" name="cardno" placeholder="" />
                                            </div>
                                            <div class="col-3"> <label class="pay">CVC*</label>
                                                <input type="password" name="cvcpwd" placeholder="***" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <label class="pay">Expiry Date*</label>
                                            </div>
                                            <div class="col-9">
                                                <select class="list-dt" id="month" name="expmonth">
                                                    <option selected>Month</option>
                                                    <option>January</option>
                                                    <option>February</option>
                                                    <option>March</option>
                                                    <option>April</option>
                                                    <option>May</option>
                                                    <option>June</option>
                                                    <option>July</option>
                                                    <option>August</option>
                                                    <option>September</option>
                                                    <option>October</option>
                                                    <option>November</option>
                                                    <option>December</option>
                                                </select>
                                                <select class="list-dt" id="year" name="expyear">
                                                    <option selected>Year</option>
                                                </select>
                                            </div>
                                        </div>-->

                                    </div>
                                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                    <input type="button" name="make_payment" class="next action-button" value="Confirm"/>
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title text-center">Success !</h2> <br><br>
                                        <div class="row justify-content-center">
                                            <div class="col-3">
                                                <img src="https://img.icons8.com/color/96/000000/ok--v2.png" class="fit-image">
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="row justify-content-center">
                                            <div class="col-7 text-center">
                                                <h5>You Have Successfully Signed Up</h5>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/encuesta.js') }}"></script>
</body>
</html>
