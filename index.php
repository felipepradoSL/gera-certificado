<?php

	/**
	* Plugin Name: Gera Certificado SL
	* Plugin URI: https://www.swetleads.com.br
	* Description: Utilizar o shortcode [certificado-form]
	* Version: 1.0
	* Author: Sweet Leads
	* Author URI: https://www.swetleads.com.br
	**/

	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
	date_default_timezone_set( 'America/Sao_Paulo' );
	require('fpdf/alphapdf.php');
	require('PHPMailer/class.phpmailer.php');

	function gera_certificado(){ 
		?>
		<!-- Formulario HTML -->
		<form class="form-horizontal" action="" method="post"  id="contact_form_quiz">
			<fieldset>
				<p>&nbsp;</p>				
				<div class="form-group">
					<label class="col-md-4 control-label" >Palavra Chave 1</label> 
					<div class="col-md-4 inputGroupContainer">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
							<input name="resposta1" placeholder="Resposta" class="form-control"  type="text" required>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" >Palavra Chave 2</label> 
					<div class="col-md-4 inputGroupContainer">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
							<input name="resposta2" placeholder="Resposta" class="form-control"  type="text" required>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" >Palavra Chave 3</label> 
					<div class="col-md-4 inputGroupContainer">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
							<input name="resposta3" placeholder="Resposta" class="form-control"  type="text" required>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label"></label>
					<div class="col-md-4">
						<button name="btn-quiz" class="btn btn-default col-md-12" >Enviar Respostas </button>
					</div>
				</div>
			</fieldset>
		</form>


		<?php 
		
		// Se o botão de enviar respostas for pressionado
		//	as respostas serão verificadas de acordo com os inputs
		if (isset($_POST['btn-quiz'])) {
			//palavras chaves para as respostas do quiz
			$keyresposta1 = "foco";
			$keyresposta2 = "maquiagem";
			$keyresposta3 = "empresaria";

			$acertos = 0; //contador de acertos

			function tirarAcentos($string){
				return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
			}			

			$resposta1 = tirarAcentos($_POST["resposta1"]);
			$resposta2 = tirarAcentos($_POST["resposta2"]);
			$resposta3 = tirarAcentos($_POST["resposta3"]);

			//verificacao das respostas e icrementa o número de acertos
			if (strtolower($resposta1) == $keyresposta1)
				$acertos++;
			if (strtolower($resposta2) == $keyresposta2)
				$acertos++;
			if (strtolower($resposta3) == $keyresposta3)
				$acertos++;	

			//Caso acertou todas as respostas
			// 	Oculta o quiz e mostra o novo formulário para gerar o certificado
			if ($acertos == 3) {
				?>
				<script>
					document.querySelector("#contact_form_quiz").style.display = "none";
					location.href = "#elementor-action%3Aaction%3Dpopup%3Aopen%26settings%3DeyJpZCI6IjE1NjkiLCJ0b2dnbGUiOmZhbHNlfQ%3D%3D";								
				</script>

				<form class="form-horizontal" action="" method="post"  id="contact_form_certicate">
					<fieldset>
						<p>&nbsp;</p>
						<div class="form-group">
							<label class="col-md-4 control-label">Nome</label>  
							<div class="col-md-4 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input  name="nome" placeholder="Nome completo" class="form-control"  type="text" maxlength="40" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail</label>  
							<div class="col-md-4 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
									<input name="email" placeholder="E-Mail" class="form-control"  type="text" required>
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
			//Caso não acerte as 3 respostas
			// oculta o formulário e mostra a mensagem
			else{
				?>
				<script>
					document.querySelector("#contact_form_quiz").style.display = "none";
					location.href = "#elementor-action%3Aaction%3Dpopup%3Aopen%26settings%3DeyJpZCI6IjE1NjkiLCJ0b2dnbGUiOmZhbHNlfQ%3D%3D";						
				</script>
				<p><h3>Infelizmente as palavras estão incorretas =(</h3><br> 
					<span style="font-size: 18px">Mas vamos lá, <b>reassista as aulas</b> e tente novamente.</span></p>
					<?php 
				}		
			};

		// condicao clique no botão de gerar certificado
			if (isset($_POST['btn-certificado'])){ 

			// ----- Variaveis do formulário
				$nome = strtoupper($_POST['nome']);
				$email = $_POST['email'];

			/** 
			/ ----- Nome do arquivo que será gerado
			/ ----- Estrutura: username do email + segundos desde a Era Unix
			/ ----- Ex.: 
			/		Entrada: email = user@email.com 
			/		Saída: user1055901520.pdf
			 **/
			$first_name_certificate =  strstr($email, '@', true);
			$today = getdate();
			$name_complete_certificate = $first_name_certificate .  $today["0"];


			$pdf = new AlphaPDF();

			// Orientação Landing Page 
			$pdf->AddPage('L');

			$pdf->SetLineWidth(1.5);

			// desenha a imagem do certificado
			$certificado_img = "/var/www/wp-content/plugins/gera-certificado/certificado.png";
			$pdf->Image($certificado_img,0,0,295,'png');

			// opacidade total
			$pdf->SetAlpha(1);

			// Mostrar o nome
			$pdf->SetFont('Arial', '', 30); // Tipo de fonte e tamanho
			$pdf->SetTextColor(158,146,123); //Cor da fonte
			$pdf->SetXY(19,62); //Parte chata onde tem que ficar ajustando a posição X e Y
			$pdf->MultiCell(265, 10, $nome, '', 'C', 0); // Tamanho width e height e posição

			// Dia
			$pdf->SetFont('Arial', 'B', 17); // Tipo de fonte e tamanho
			$pdf->SetTextColor(158,146,123); //Cor da fonte
			$pdf->SetXY(37,123); //Parte chata onde tem que ficar ajustando a posição X e Y
			$pdf->MultiCell(165, 10, $today['mday'], '', 'C', 0); // Tamanho width e height e posição


			// retorna o documento como string
			$pdfdoc = $pdf->Output('', 'S');


			//  enviar o e-mail pro usuário contendo o anexo
			// e também mostrar na tela para caso o e-mail não chegar
			$subject = 'Seu Certificado do Workshop';
			$messageBody = "Olá $nome<br><br>É com grande prazer que entregamos o seu certificado.<br>Ele está em anexo nesse e-mail.<br><br>Atenciosamente,<br>Catlen Guerra<br>";

			$certificado= "/var/www/certificados/$name_complete_certificate.pdf"; //atribui a variável $certificado com o caminho e o nome do arquivo que será salvo 

			$pdf->Output($certificado,'F'); //Salva o certificado no servidor (verifique se a pasta "certificados" tem a permissão necessária)
			
			//$pdf->Output(); // Mostrar o certificado na tela do navegador

			//gera a url para o certificado gerado
			$urlDownload =  'http://' . $_SERVER['HTTP_HOST'] . '/certificados/' .  $name_complete_certificate . '.pdf';

			//envia o email com o certificado em anexo e faz o download automaticamente
			try{
				$mail = new PHPMailer();
				$mail->SetFrom("contato@catlenguerra.com.br", "Catlen Guerra");
				$mail->Subject    = $subject;
				$mail->MsgHTML(utf8_decode($messageBody));
				$mail->AddAddress($email); 
				$mail->addStringAttachment($pdfdoc, 'certificado.pdf');

				$mail->Send()

				?>
				<style>#contact_form_quiz{display:none !important;}#contact_form_certicate{display: none !important;}</style>
				<div class="sent-contact">
					<p><b style="font-size: 28px">PARABÉNS!</b><br><br>
						Agora você possui o certificado de conclusão do curso <br><br>
						<span style="font-size: 18px">Workshop Online de Maquiagem Profissional com Catlen Guerra</span><br><br>

						<a href="<?php  echo $urlDownload;?>" style="border: 1px solid;border-radius: 5px;padding: 5px">DOWNLOAD DO CERTIFICADO</a><br><br>

						Também enviamos o certificado para seu email, confira lá! =D
						
					</p>
				</div>			
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