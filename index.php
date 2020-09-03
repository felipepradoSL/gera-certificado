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

				// Formulario HTML
		?>
		<form class="form-horizontal" action="" method="post"  id="contact_form_quiz">
			<fieldset>
				<center>
					<h1>Quiz da Catlen</h1>
				</center>
				<p>&nbsp;</p>				
				<div class="form-group">
					<label class="col-md-4 control-label" >Pergunta</label> 
					<div class="col-md-4 inputGroupContainer">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
							<input name="resposta1" placeholder="Resposta" class="form-control"  type="text">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" >Pergunta</label> 
					<div class="col-md-4 inputGroupContainer">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
							<input name="resposta2" placeholder="Resposta" class="form-control"  type="text">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" >Pergunta</label> 
					<div class="col-md-4 inputGroupContainer">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
							<input name="resposta3" placeholder="Resposta" class="form-control"  type="text">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label"></label>
					<div class="col-md-4">
						<button type="submit" name="btn-quiz" class="btn btn-default col-md-12" >Enviar Respostas </button>
					</div>
				</div>
			</fieldset>
			<div id="msg_contact_certificate"></div>
		</form>

		<?php 

		if (isset($_POST['btn-quiz'])) {
			$resposta1 = $_POST["resposta1"];
			$resposta2 = $_POST["resposta2"];
			$resposta3 = $_POST["resposta3"];


			$keys = array("resposta1", "resposta2", "resposta3");
			$acertos = 0;

			if (in_array($resposta1, $keys))
				$acertos++;
			if (in_array($resposta2, $keys))
				$acertos++;
			if (in_array($resposta3, $keys))
				$acertos++;	

			if ($acertos == 3) {
				?>
				<script>
					document.querySelector("#contact_form_quiz").style.display = "none";					
				</script>

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
									<input  name="nome" placeholder="Nome completo" class="form-control"  type="text" maxlength="33">
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
							<label class="col-md-4 control-label"></label>
							<div class="col-md-4">
								<button type="submit" name="btn-certificado" class="btn btn-default col-md-12" >Gerar Certificado <span class="glyphicon glyphicon-download-alt"></span></button>
							</div>
						</div>
					</fieldset>
					<div id="msg_contact_certificate"></div>
				</form>
				<?php 

			}else{
				echo "Infelizmente você não acertou a quantidade suficiente para o certificado =(";
			}		


		};

		// condicao clique no botão de gerar certificado
		if (isset($_POST['btn-certificado'])){ 

			// ----- Variaveis do formulário
			$nome = strtoupper($_POST['nome']);
			$email = $_POST['email'];
			/** 
			/ ----- Nome do arquivo que será gerado
			/ ----- Estrutura: username do email + data atual (zero não precede qualquer número)
			/ ----- Ex.: 
			/		Entrada: email = user@email.com | data = 20/08/2020
			/		Saída: user2082020.pdf
			 **/
			$first_name_certificate =  strstr($email, '@', true);
			$today = getdate();
			echo "day: " . $today['mday'];
			echo "month: " . $today['mon'];
			echo "year: " . $today['year'];
			$name_complete_certificate = $first_name_certificate .  $today['mday'] . $today['mon'] . $today['year'];


			$pdf = new AlphaPDF();

			// Orientação Landing Page ///
			$pdf->AddPage('L');

			$pdf->SetLineWidth(1.5);

			// desenha a imagem do certificado
			$certificado_img = "/var/www/wp-content/plugins/gera-certificado/certificado.png";
			$pdf->Image($certificado_img,0,0,295,'png');

			// opacidade total
			$pdf->SetAlpha(1);



			// Mostrar o nome
			$pdf->SetFont('Arial', '', 30); // Tipo de fonte e tamanho
			$pdf->SetXY(20,60); //Parte chata onde tem que ficar ajustando a posição X e Y
			$pdf->MultiCell(265, 10, $nome, '', 'C', 0); // Tamanho width e height e posição

				// Mostrar o corpo
				//$pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
				//$pdf->SetXY(20,110); //Parte chata onde tem que ficar ajustando a posição X e Y
				//$pdf->MultiCell(265, 10, $texto2, '', 'C', 0); // Tamanho width e height e posição

				// Mostrar a data no final
				//$pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
				//$pdf->SetXY(32,172); //Parte chata onde tem que ficar ajustando a posição X e Y
				//$pdf->MultiCell(165, 10, $texto3, '', 'L', 0); // Tamanho width e height e posição

			$pdfdoc = $pdf->Output('', 'S');


				// ******** Agora vai enviar o e-mail pro usuário contendo o anexo
				// ******** e também mostrar na tela para caso o e-mail não chegar

			$subject = 'Seu Certificado do Workshop';
			$messageBody = "Olá $nome<br><br>É com grande prazer que entregamos o seu certificado.<br>Ele está em anexo nesse e-mail.<br><br>Atenciosamente,<br>Lincoln Borges<br>";

			$certificado= "/var/www/certificados/$name_complete_certificate.pdf"; //atribui a variável $certificado com o caminho e o nome do arquivo que será salvo (vai usar o CPF digitado pelo usuário como nome de arquivo)
			$pdf->Output($certificado,'F'); //Salva o certificado no servidor (verifique se a pasta "arquivos" tem a permissão necessária)
				//$pdf->Output(); // Mostrar o certificado na tela do navegador

			$urlDownload =  'http://' . $_SERVER['HTTP_HOST'] . '/certificados/' .  $name_complete_certificate . '.pdf';

			try{
				$mail = new PHPMailer();
				$mail->SetFrom("certificado@sweetleads.com.br", "Certificado");
				$mail->Subject    = $subject;
				$mail->MsgHTML(utf8_decode($messageBody));
				$mail->AddAddress($email); 
				$mail->addStringAttachment($pdfdoc, 'certificado.pdf');

				$mail->Send()

				?>
				<div class="sent-contact">
					<p>&#10004; Mensagem enviada com sucesso. Te responderemos em breve.</p>
				</div>

				<script language="javascript">
					window.open('<?php echo $urlDownload; ?>','_blank');
				</script>
				<?php 

			}
			catch (Exeption $e){
				?>
				<div class="error-contact">&#10008; Não foi possível enviar seu certificado por e-mail. Verifique se " <?php echo $email ?> " está correto e tente novamente. Para baixar seu certificado, clique em <a href="<?php echo $urlDownload ?>">BAIXAR CERTIFICADO</a> </div>
				<?php
			}				

		}



	}

	add_shortcode('certificado-form','gera_certificado');