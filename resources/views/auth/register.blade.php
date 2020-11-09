@extends('layouts.admin')

@section('content')
@section('bodyclass')
    <body class="gray-bg">
    @endsection
    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>
                <h3 class="logo-name">{{config('app.name_short')}}</h3>
            </div>
            
            @if ( session('status'))
                <div class="row">
                        <div class="alert alert-{{ session('type') }}">
                        {{ session('status') }}
                        </div>
                </div>
            @else
                <div class="row">
                        <div class="alert alert-info">
                            Asegúrese de usar un correo valido para evitar futuros problema de verificación de correo. <br />
                            (De preferencia usar un correo de GMAIL)
                        </div>
                </div>
            @endif

            <form class="m-t{{ $errors->has('other') ? ' has-error' : '' }}" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required
                           placeholder="Usuario" autofocus>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{$errors->first('name')}}</strong>
                        </span>
                    @endif

                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                           placeholder="E-mail" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif

                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                    <input id="password" type="password" class="form-control" name="password" required
                           placeholder="Introducir la contraseña">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif

                </div>

                <div class="form-group">


                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           required placeholder="Repite la contraseña">

                </div>
                <div class="form-group{{ $errors->has('recruiter_name') ? ' has-error' : '' }}">
                @if($recruiter)
                    <input type="text" class="form-control" readonly value="Inviter: {{$recruiter->name}}">
                    <input id="recruiter-name" type="hidden" class="form-control" readonly name="recruiter_name" value="{{$recruiter->name}}">
                @else
                    <input id="recruiter-name" type="text" class="form-control" name="recruiter_name" value="" placeholder="Invitador (no es necesario)">
                @endif
                @if ($errors->has('recruiter_name'))
                    <span class="help-block">
                        <strong>{{$errors->first('recruiter_name')}}</strong>
                    </span>
                @endif
                </div>
                
                <div class="form-group">
                    <input id="phone-number" type="text" onKeyPress="cislo()" class="form-control" name="phone" value="" placeholder="Teléfono (no es necesario)">
                </div>

                <div class="form-group{{ $errors->has('terms') ? ' has-error' : '' }}">
                    <div class="checkbox checkbox-primary">
                        <input id="terms" type="checkbox" name="terms" value="yes">
                        <label id="checkbox"><small>Aceptar <a href="" data-toggle="modal" data-target=".bs-modal-lg"><b>acuerdo de licencia</b></a></small> </label>
                    </div>                   
                     @if ($errors->has('terms'))
                        <span class="help-block">
                            <strong>{{$errors->first('terms')}}</strong>
                        </span>
                    @endif
                </div>
                
                <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                               
                    @if(env('GOOGLE_RECAPTCHA_KEY'))
                         <div class="g-recaptcha"
                              data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                         </div>
                    @endif
                               
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                    @endif
                </div>
                               
                <button type="submit" class="btn btn-primary block full-width m-b">Regístrate</button>
                
                @if ($errors->has('other'))
                    <span class="help-block">
                        <strong>{{ $errors->first('other') }}</strong>
                    </span>
                @endif

                <p class="text-muted text-center">
                    <small>Ya tienes una cuenta?</small>
                </p>
                <a class="btn btn-sm btn-white btn-block" href="{{ url('/login') }}">Iniciar sesión</a>
            </form>
            <p class="m-t">
                <small>&copy; {{now()->year.' '.config('app.name_prj')}}</small>
            </p>
        </div>
                <div class="modal fade bs-modal-lg" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">TÉRMINOS DE USO</h4>
                        </div>
                        <div class="modal-body">
                           Al acceder o utilizar www.wowtales.org (el "Sitio") y los servicios afiliados (los "Servicios") que pertenecen a WoW Tales, usted (el "Usuario") acepta cumplir con los términos y condiciones que rigen el uso del Usuario de cualquier área del Sitio y servicios afiliados como se establece a continuación.
                        </div>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">USO DEL SITIO</h4>
                        </div>
                        <div class="modal-body">
                           Este Sitio o cualquier parte del Sitio, así como los Servicios, no pueden reproducirse, duplicarse, copiarse, venderse, revenderse ni explotarse de ningún otro modo para ningún fin comercial, excepto según lo permita expresamente WoW Tales. WoW Tales se reserva el derecho de rechazar el servicio a su discreción, sin limitación, si WoW Tales cree que la conducta del Usuario viola la ley aplicable o es perjudicial para los intereses de WoW Tales, otros usuarios del Sitio y los Servicios o sus afiliados.
                        </div>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">CUENTA DEL SITIO</h4>
                        </div>
                        <div class="modal-body">
                            Puede registrar una cuenta regular y una contraseña para el servicio de forma gratuita. Usted es responsable de todas las actividades de su cuenta, cuentas asociadas y contraseñas. El Sitio NO es responsable del acceso no autorizado a su cuenta y de cualquier pérdida de elementos virtuales asociados a ella.
                        </div>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">ACCESO AL SITIO Y LOS SERVICIOS</h4>
                        </div>
                        <div class="modal-body">
                            WoW Tales proporciona acceso gratuito e ilimitado al Sitio y a los Servicios.
                        </div>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">SUMISIÓN</h4>
                        </div>
                        <div class="modal-body">
                            WoW Tales no asume ninguna obligación con respecto a ninguna Presentación y no se establece ninguna comprensión o relación confidencial o fiduciaria por la recepción o aceptación de cualquier presentación por parte del Sitio. Todos los envíos se convierten en propiedad exclusiva del Sitio y sus afiliados. El Sitio y sus afiliados pueden usar cualquier envío sin restricción y el Usuario no tendrá derecho a ninguna compensación.
                        </div>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">VERIFICACIÓN</h4>
                        </div>
                        <div class="modal-body">
                            AL USUARIO SE LE PODRÁ REQUERIR QUE SE REALICE UN PROCEDIMIENTO DE VERIFICACIÓN QUE INCLUYA, SIN LIMITARSE A, LA PRESENTACIÓN DE INFORMACIÓN NECESARIA Y / O DOCUMENTOS PARA ASEGURAR LA LEGITIMIDAD DE CUALQUIER PAGO O DONACIÓN DEBEMOS CONSIDERAR CUALQUIER PAGO O DONACIÓN SOSPECHOSA. LAS CUENTAS EN PROCESO DE VERIFICACIÓN PERMANECEN DESACTIVADAS HASTA QUE EL PROCEDIMIENTO DE VERIFICACIÓN SE COMPLETE. LA INFORMACIÓN PRESENTADA PUEDE SER REVELADA A NUESTROS AFILIADOS EN NUESTROS ESFUERZOS MUTUOS PARA EVITAR PAGOS / DONACIONES NO AUTORIZADOS. LA INFORMACIÓN SOLICITADA DEBE SER ENVIADA POR CORREO ELECTRÓNICO / FAX / FORMULARIO EN LÍNEA Y PUEDE INCLUIR LA VERIFICACIÓN DE LA IDENTIDAD DEL USUARIO. <br>
                            Contenido de terceros <br><br>
                            Ni WoW Tales, ni sus afiliados, ni ninguno de sus respectivos funcionarios, directores, empleados o agentes, ni ningún tercero, incluido ningún Proveedor / Afiliado, o cualquier otro Usuario del Sitio y los Servicios, garantiza la precisión, integridad o utilidad de cualquier contenido, ni su comerciabilidad o idoneidad para un propósito particular. En algunos casos, el contenido disponible a través del Sitio puede representar las opiniones y juicios de Proveedores / Afiliados o Usuarios. WoW Tales y sus afiliados no respaldan y no serán responsables de la exactitud o confiabilidad de cualquier opinión, consejo o declaración hecha en el Sitio y los Servicios por nadie más que los empleados autorizados de WoW Tales. Bajo ninguna circunstancia WoW Tales, o sus afiliados, o cualquiera de sus respectivos funcionarios, directores, empleados o agentes serán responsables de cualquier pérdida, daño o daño causado por la dependencia del Usuario de la información obtenida a través del Sitio y los Servicios. Es responsabilidad del Usuario evaluar la información, opinión, asesoramiento u otro Contenido disponible a través de este Sitio. <br>
                            Descargos de responsabilidad y limitación de responsabilidad <br><br>
                            El usuario acepta que el uso del Sitio y los Servicios es bajo su propio riesgo. Ni WoW Tales, ni sus afiliados, ni ninguno de sus respectivos funcionarios, directores, empleados, agentes, proveedores de contenido de terceros, comerciantes, patrocinadores, licenciantes o similares (colectivamente, "Proveedores"), garantizan que el Sitio y los Servicios será ininterrumpido o sin errores; ni ofrecen ninguna garantía en cuanto a los resultados que pueden obtenerse del uso del Sitio y los Servicios, o en cuanto a la precisión, confiabilidad o vigencia de cualquier contenido de información, servicio o mercancía proporcionada a través de este Sitio. EL SITIO Y LOS SERVICIOS SON PROPORCIONADOS POR WoW Tales EN UNA BASE "TAL CUAL" Y "DISPONIBLE". EL SITIO NO OFRECE REPRESENTACIONES O GARANTÍAS DE NINGÚN TIPO, EXPRESAS O IMPLÍCITAS, EN CUANTO A LA OPERACIÓN DEL SITIO, LA INFORMACIÓN, CONTENIDO, MATERIALES O PRODUCTOS, INCLUIDOS EN ESTE SITIO. EN LA MEDIDA PERMISIBLE DE LA LEY APLICABLE, EL SITIO RECHAZA TODAS LAS GARANTÍAS, EXPRESAS O IMPLÍCITAS, INCLUYENDO, PERO SIN LIMITACIÓN, LAS GARANTÍAS IMPLÍCITAS DE COMERCIABILIDAD Y ADECUACIÓN PARA UN PROPÓSITO EN PARTICULAR. WoW Tales NO SERÁ RESPONSABLE DE NINGÚN DAÑO DE NINGÚN TIPO DERIVADO DEL USO DEL SITIO Y LOS SERVICIOS, INCLUYENDO PERO NO LIMITADO A DAÑOS DIRECTOS, INDIRECTOS, INCIDENTALES, PUNITIVOS Y CONSECUENTES. Bajo ninguna circunstancia, WoW Tales o cualquier otra parte involucrada en la creación, producción o distribución del Sitio y los Servicios serán responsables de los daños directos, indirectos, incidentales, especiales o consecuentes que resulten del uso o la imposibilidad de usar el Sitio. y los Servicios, que incluyen, entre otros, la confianza del Usuario en cualquier información obtenida del Sitio o que resulte de errores, omisiones, interrupciones, eliminación de archivos o correo electrónico, errores, defectos, virus, retrasos en la operación o transmisión, o cualquier falla de desempeño, ya sea como resultado de actos de Dios, falla de comunicación, robo, destrucción o acceso no autorizado a los registros, programas o servicios del Sitio. El usuario por la presente reconoce que estas renuncias y limitaciones de responsabilidad se aplicarán a todo el contenido, la mercancía y los servicios disponibles a través del Sitio y los Servicios. En los estados que no permiten la exclusión de la limitación o la limitación de la responsabilidad por daños consecuentes o incidentales, el Usuario acepta que la responsabilidad en dichos estados se limitará en la mayor medida permitida por la ley aplicable.
                        </div>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">TERMINACIÓN DEL SERVICIO</h4>
                        </div>
                        <div class="modal-body">
                            WoW Tales se reserva el derecho, a su sola discreción, de cambiar, suspender, limitar o descontinuar cualquier aspecto del Servicio y los Servicios en cualquier momento. WoW Tales puede suspender o cancelar el acceso de cualquier Usuario a todo o parte del Sitio y los Servicios, sin previo aviso, por cualquier conducta que WoW Tales, a su exclusivo criterio, crea que viola estos términos y condiciones.
                        </div>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">RECONOCIMIENTO</h4>
                        </div>
                        <div class="modal-body">
                            Al acceder o utilizar el Sitio y los Servicios, EL USUARIO ACUERDA ESTAR OBLIGADO POR ESTOS TÉRMINOS Y CONDICIONES, INCLUIDAS LAS RENUNCIAS. WoW Tales se reserva el derecho de realizar cambios en el Sitio y estos términos y condiciones, incluidas las renuncias, en cualquier momento. SI NO ACEPTA LAS DISPOSICIONES DE ESTE ACUERDO O NO ESTÁ SATISFECHO CON EL SERVICIO, SU ÚNICO Y EXCLUSIVO REMEDIO ES DEJAR DE USAR EL SERVICIO.
                        </div>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">DECLARACION DE PRIVACIDAD</h4>
                        </div>
                        <div class="modal-body">
                            Cierta información del usuario recopilada mediante el uso de este sitio web se almacena automáticamente como referencia. Rastreamos dicha información para realizar una investigación interna sobre los intereses y el comportamiento demográfico de nuestros usuarios y para comprender, proteger y servir mejor a nuestra comunidad de usuarios. El pago o cualquier otra información financiera NUNCA se envía, divulga o almacena en el Sitio y está sujeto a los Términos y condiciones y la Política de privacidad de nuestros respectivos socios y / o procesadores de pagos. La información básica del usuario (como la dirección IP, los registros para usar la interfaz del sitio web y la administración de cuentas) puede divulgarse a nuestros socios en un esfuerzo mutuo para contrarrestar posibles actividades ilegales. WoW Tales hace un esfuerzo significativo para proteger.
                        </div>                                                 
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Estoy de acuerdo</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
    </div>
    <script>
    function cislo(){
        if (event.keyCode < 48 || event.keyCode > 57)
            event.returnValue= false;
    }
    </script>
@endsection
