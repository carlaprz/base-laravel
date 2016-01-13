
<!DOCTYPE html>
<html>
    <head>
        <title></title>

        <style type="text/css">
            body  {
                font-family: Arial;
                font-size: 0.85em;
            }

            #bill {
                width: 1000px;
                margin: 0 auto;
            }

            section, table {
                margin-top: 80px;
                width: 100%;
            }

            table {
                border-collapse: collapse;
                border-spacing: 0;
            }

            .facturacion td {
                line-height: 20px;
            }

            table td, table th {
                border: 2px solid #ECECEC;
                text-align: left;
                height: 40px;
                line-height: 40px;
                vertical-align: top;
                padding: 0 10px;
            }
            table.detalle {
                border: 2px solid #ECECEC;
                line-height: 20px;
            }

            table.detalle th, table.detalle td{
                width: 20%;
                text-align: center;
            }

            table.detalle th:first-child, table.detalle td:first-child{
                width: 40%;
                text-align: left;
            }

            table.detalle th:last-child, table.detalle td:last-child{
                width: 10%;
                text-align: center;
            }

            table.detalle td, table.detalle th {
                border: 0px solid white;
            }
            .cabeceraTabla {
                background-color: #ECECEC;
            }


            .footer {
                background-color: #ECECEC;
                padding: 30px 0;
            }

            .footer p {
                text-align: center;
            }

        </style>
    </head>
    <body>
        <div id="bill">
            <header>
                <img src="/images/logo.jpg">
            </header>
            <section>
                <p>Hola {{$data->userNameLastName}}:</p>
                <p><strong>Gracias por comprar en  {{ Config::get('app.url')}}</strong></p>
                <p>Tu pedido ha sido recibido correctamente. A continuación te mostramos los datos de compra.</p>
            </section>

            <section>
                <p>Número de pedido: {{$data->id}}</p>
                <p>Fecha del pedido: {{$data->created_at}}</p>
            </section>

            <table class="facturacion">
                <tr class="cabeceraTabla">
                    <th>DATOS DE FACTURACIÓN</th>
                    <th>DATOS DE ENVÍO</th>
                </tr>
                <tr>
                    <td>{{$data->userNameLastName}}<br/>
                        {{$user->address}}<br/>
                        {{$user->city}}, {{$user->province}} , {{$user->postalcode}} <br/>
                        {{$user->country_name}}<br/>
                        T: {{$user->telephone}}<br/>
                        Email: {{$user->email}}</td>

                    <td>{{$shipping["shipping_name"]}} {{$shipping["shipping_lastname"]}}<br/>
                        {{$shipping["shipping_address"]}}<br/>
                        {{$data->country_name}}, {{$shipping["shipping_postalcode"]}}<br/>

                        T:{{$shipping["shipping_telephone"]}}<br/>
                </tr>
            </table>

            <table class="detalle">
                <tr class="cabeceraTabla">
                    <th>Artículo</th>
                    <th>Ref.</th>
                    <th>Pvp</th>
                    <th>IVA</th>
                    <th>Cant.</th>
                </tr>
                
                @foreach($products as $product)
                <tr>
                    <td><strong>{{$product["product_description"]}}</strong></td>
                    <td> {{$product["id"]}} </td>
                    <td> {{$product["pvp"]}}  </td>
                    <td> {{$product["iva"]}}  </td>
                    <td> {{$product["cant"]}}  </td>
                </tr>
                @endforeach
            </table>

            <table>
                <tr class="cabeceraTabla">
                    <th>FORMA DE PAGO</th>
                </tr>
                <tr>
                    <td>
                        {{$data->pvpName}}
                    </td>
                </tr>
            </table>

            <section class="footer">
                <p>Si tienes alguna duda sobre tu pedido, contacta con nuestro Servicio de Atención al cliente <a href="mailto:base@base.com.es">base@base.es</a></p>
                <p>¡Disfruta de tu compra! Gracias por confiar en nosotros</p>
                <p><strong> Equipo BaseProject</strong></p>
            </section>

        </div>
    </body>
</html>