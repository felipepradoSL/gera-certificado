<?php
/**
	* Plugin Name: Gera Certificado SL
	* Plugin URI: https://www.swetleads.com.br
	* Version: 1.0
	* Author: Sweet Leads
	* Author URI: https://www.swetleads.com.br
	**/

	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
	date_default_timezone_set( 'America/Sao_Paulo' );
	require('fpdf/alphapdf.php');
	require('PHPMailer/class.phpmailer.php');	

	function gera_certificado(){ 

		if (isset($_POST['btn-certificado'])){ 
			// ----- Variaveis do formulário
			$nome = $_POST['nome'];
			$email = $_POST['email'];
			$first_name_certificate =  strstr($email, '@', true);
			$today = getdate();
			$name_complete_certificate = $first_name_certificate .  $today['mday'] . $today['mon'] . $today['year'];
			
			$resposta = explode(" ", $_POST['resposta']);

			// ----- Variaveis de controle
			$acertou = false;
			$keyword = "maquiagem";

			
			//---- verifica a resposta
			foreach ($resposta as $key) {

				if ($key == $keyword)
					$acertou = true;				
			}

			if($acertou){
				// ----- Variáveis de informações
				$empresa  = "Universidade do Lincoln Borges";
				$curso    = "Workshop Segurança da Informação";
				$data     = "29/05/2017";
				$carga_h  = "8 horas";

				$texto1 = utf8_decode($empresa);
				$texto2 = utf8_decode("pela participação no ".$curso." \n realizado em ".$data." com carga horária total de ".$carga_h.".");
				$texto3 = utf8_decode("São Paulo, ".utf8_encode(strftime( '%d de %B de %Y', strtotime( date( 'Y-m-d' ) ) )));

				$pdf = new AlphaPDF();

				// Orientação Landing Page ///
				$pdf->AddPage('L');

				$pdf->SetLineWidth(1.5);

				// desenha a imagem do certificado
				$certificado_img = "/var/www/wp-content/plugins/gera-certificado/certificado.png";
				$pdf->Image($certificado_img,0,0,295,'png');

				// opacidade total
				$pdf->SetAlpha(1);

				// Mostrar texto no topo 
				//cor do texto #9E927B
				$pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
				$pdf->SetXY(109,46); //Parte chata onde tem que ficar ajustando a posição X e Y
				$pdf->MultiCell(265, 10, $texto1, '', 'L', 0); // Tamanho width e height e posição

				// Mostrar o nome
				$pdf->SetFont('Arial', '', 30); // Tipo de fonte e tamanho
				$pdf->SetXY(20,86); //Parte chata onde tem que ficar ajustando a posição X e Y
				$pdf->MultiCell(265, 10, $nome, '', 'C', 0); // Tamanho width e height e posição

				// Mostrar o corpo
				$pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
				$pdf->SetXY(20,110); //Parte chata onde tem que ficar ajustando a posição X e Y
				$pdf->MultiCell(265, 10, $texto2, '', 'C', 0); // Tamanho width e height e posição

				// Mostrar a data no final
				$pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
				$pdf->SetXY(32,172); //Parte chata onde tem que ficar ajustando a posição X e Y
				$pdf->MultiCell(165, 10, $texto3, '', 'L', 0); // Tamanho width e height e posição

				$pdfdoc = $pdf->Output('', 'S');


				// ******** Agora vai enviar o e-mail pro usuário contendo o anexo
				// ******** e também mostrar na tela para caso o e-mail não chegar

				$subject = 'Seu Certificado do Workshop';
				$messageBody = "Olá $nome<br><br>É com grande prazer que entregamos o seu certificado.<br>Ele está em anexo nesse e-mail.<br><br>Atenciosamente,<br>Lincoln Borges<br>";


				$mail = new PHPMailer();
				$mail->SetFrom("certificado@sweetleads.com.br", "Certificado");
				$mail->Subject    = $subject;
				$mail->MsgHTML(utf8_decode($messageBody));
				$mail->AddAddress($email); 
				$mail->addStringAttachment($pdfdoc, 'certificado.pdf');

				$certificado= "/var/www/certificados/$name_complete_certificate.pdf"; //atribui a variável $certificado com o caminho e o nome do arquivo que será salvo (vai usar o CPF digitado pelo usuário como nome de arquivo)
				$pdf->Output($certificado,'F'); //Salva o certificado no servidor (verifique se a pasta "arquivos" tem a permissão necessária)
		//$pdf->Output(); // Mostrar o certificado na tela do navegador

				$urlDownload =  'http://' . $_SERVER['HTTP_HOST'] . '/certificados/' .  $name_complete_certificate . '.pdf';


				if ($mail->Send())
				{
					$errorMail = error_get_last();
					?>
					<div class="error-contact">&#10008; Não foi possível enviar seu certificado por e-mail. Verifique se " <?php echo $email ?> " está correto e tente novamente. Para baixar seu certificado, clique em <a href="<?php echo $urlDownload ?>">BAIXAR CERTIFICADO</a> </div>
					<?php 		
				} 
				else
				{


					?>
					<p>ENDEREÇO: <?php echo $urlDownload ?></p>
					<div class="sent-contact">&#10004; Mensagem enviada com sucesso. Te responderemos em breve.</div>
					<script language="javascript">

						window.open('<?php echo $urlDownload; ?>','_blank');
					</script>
					<?php
				}


				}//encerra if

			}

			?>


			<form class="form-horizontal" action="" method="post"  id="contact_form_certicate">
				<fieldset>
					<center>
						<h1>Gere seu certificado de Conclusão</h1>
					</center>
					<p>&nbsp;</p>
					<div class="form-group">
						<label class="col-md-4 control-label">Nome</label>  
						<div class="col-md-4 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input  name="nome" placeholder="Nome completo" class="form-control"  type="text">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label">E-Mail</label>  
						<div class="col-md-4 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<input name="email" placeholder="E-Mail" class="form-control"  type="text">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" >Pergunta</label> 
						<div class="col-md-4 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
								<input name="resposta" placeholder="Resposta" class="form-control"  type="text">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label"></label>
						<div class="col-md-4">
							<button type="submit" name="btn-certificado" class="btn btn-default col-md-12" >Gerar Certificado <span class="glyphicon glyphicon-download-alt"></span></button>
						</div>
					</div>
				</fieldset>
				<div id="msg_contact_certificate"></div>
			</form>

			<?php 

		}

		add_shortcode('certificado-form','gera_certificado');