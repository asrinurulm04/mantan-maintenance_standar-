<!doctype html>
<html>
	<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Boardicle Email</title>
	</head>
	<body class="">
		<table border="0" cellpadding="0" cellspacing="0" class="body">
    	<tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">
            <!-- START CENTERED WHITE CONTAINER -->
            <table class="main">
              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper">
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>
                        <p>Hai !</p>
                        <p>{{$info}}</p>
                          <table border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                              <tr>
                                <td align="left">
                                  <table border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                    	<tr>
                                        <td> 
																					<div class="container">
                                            <hr>
																						Dengan data sebagai berikut : <br><br>
																						<table>
																							@foreach($data as $data)
																							<tr><td>Kode Formula</td><td>: {{$data->kode_formula}}</td></tr>
																							<tr><td>Kode Revisi Formula</td><td>: {{$data->kode_revisi_formula}}</td></tr>
																							<tr><td>Nama Standar</td><td>: {{$data->nama_item}}</td></tr>
																							<tr><td>Alasan</td><td>: {{$alasan}}</td></tr>
																							<tr><td>Tanggal Kadaluarsa</td><td>: {{$data->tgl_kadaluarsa_rnd}}</td></tr>
																							@endforeach
																						</table>
                                            <hr><br> <br>
																						Terimakasih,<br>
																						Admin
                                          </div>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                      </td>
                    </tr>
                  </table>
                </td>
							</tr>	
            </table>
          </div>
        </td>
        <td>&nbsp;</td>
    	</tr>
		</table>
	</body>
</html>