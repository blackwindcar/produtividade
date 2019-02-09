<?php

require(php/base.php);

$servername = "localhost";
$username = "pedacinh_admin";
$password = "1Atiago3b$";
$db = "pedacinh_at";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    header('Location: erroBaseDados.php');
    exit;
}


session_cache_limiter('private');
$cache_limiter = session_cache_limiter();

/* define o prazo do cache em 30 minutos */
session_cache_expire(60);
$cache_expire = session_cache_expire();

/* inicia a sessão */

session_start();


$_SESSION['user'] = "htcardoso";
$_SESSION['pass'] = "HCnos_20182";

if((!$_SESSION['user'])&&(!$_SESSION['pass'])){
    header('Location: login.php');
    exit;
}

//verifica se o user e a senha existem

$sql = "SELECT count(*) num from user WHERE user.id='".$_SESSION['user']."' AND user.senha ='".$_SESSION['pass']."';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if($row["num"]==0){
    header('Location: login.php');
    exit;
}

?>


<!DOCTYPE html>
<html lang="pt">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	
	<title>Folha de Produtividade</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script>
		function mudaCliente(){
			console.log("mudaclt");
			document.getElementById("historicoMain").style.display= "none";
			document.getElementById("clienteMain").style.display= "inherit";
			document.getElementById("histDia").style.backgroundColor = "#BBBBBB";
			document.getElementById("histCliente").style.backgroundColor = "#EEEEEE";
		}
		function mudahistorico(){
			console.log("mudahistorico");
			document.getElementById("clienteMain").style.display= "none";
			document.getElementById("historicoMain").style.display= "inherit";
			document.getElementById("histDia").style.backgroundColor = "#EEEEEE";
			document.getElementById("histCliente").style.backgroundColor = "#BBBBBB";
		}
		function esconderodape(cabecalho,botao,rodape){
			console.log(cabecalho);
			console.log(botao);
			if(document.getElementById(rodape).style.display==="none"){
				document.getElementById(rodape).style.display = "inherit";
				document.getElementById(cabecalho).style.borderRadius = "10px 10px 0px 0px";
				document.getElementById(botao).innerHTML = "-";
			}
			else{
				document.getElementById(cabecalho).style.borderRadius = "10px 10px 10px 10px";
				document.getElementById(rodape).style.display = "none";
				document.getElementById(botao).innerHTML = "+";
			}
		}
		
		function carregaTecnico(){
		    var numtec = document.getElementById("numtec").value;
		    var numconta= document.getElementById("pesquisacontaservico").value;
		    
		    if(numtec != ""){
		        
		        if(numconta != ""){
		            window.location.replace("index.php?numTecnico="+numtec+"&numconta="+numconta);
		        }else{
		            window.location.replace("index.php?numTecnico="+numtec);
		        }
		    }else{
		        if(numconta != ""){
		            window.location.replace("index.php?numconta="+numconta);
		        }
		    }
		}
	</script>
</head>
<body>
	<div class="container-fluid" style="padding-right: 0px;padding-left: 0px;">
		<div class="row" id="cabecalho" style="width:100%;height: 100px;background-color: #999999;">
			<div class="col-md-3" style="text-align: center;">
				<h3 style="margin-bottom: 0px;margin-top: 7px;">Folha de</h3>
				<h1 style="margin-top: 0px;">Produtividade</h1>
			</div>
			<div style="text-align: center;" class="col-md-6">
				<img src="http://cdn.nos.pt/common/img/nos.png" style="margin-top: 20px;">
			</div>
			<div style="text-align: center;" class="col-md-1">
			</div>
			<div class="col-md-2" style="text-align: center;">
				<button type="button" id="botaoLogout" style="width: 80%;height: 40px;margin-top: 30px;border-style: solid;border-radius: 10px;border-color: #BBBBBB;font-size: large;color: white;background-color: #AAAAAA;">Sair</button>
			</div>
		</div>
		<div id="navegacao" class="row" style="width:100%;height: 50px;background-color: #CCCCCC;">
			<div style="text-align: center;" class="col-md-4">
				<input id = "numtec" style="width: 40%;text-align: center;font-size: large;border-style: solid;border-radius: 20px;height: 40px;margin-top: 5px;" placeholder="9XXXXXXXX" type="text" value="<?php if($_GET["numTecnico"]){echo($_GET["numTecnico"]);}?>">
				<button type="button" style="width: 15%;height: 40px;border-style: solid;border-radius: 15px;margin-left: 5px;margin-top: 5px;" onClick="carregaTecnico()">🔍</button>
			</div>
			<div style="text-align: left;" class="col-md-4">
				<input id="pesquisacontaservico" style="width: 40%;text-align: center;font-size: large;border-style: solid;border-radius: 20px;height: 40px;margin-top: 5px;" placeholder="Conta de Serviço" type="text" value="<?php if($_GET["numconta"]){echo($_GET["numconta"]);}?>">
				<button type="button" style="width: 15%;height: 40px;border-style: solid;border-radius: 15px;margin-left: 5px;margin-top: 5px;" onClick="carregaTecnico()">🔍</button>
			</div>
			<div class="col-md-1">
			</div>
			<div class="col-md-3" style="text-align: center;">
				<button type="button" id="histCliente" style="width: 40%; height: 40px; margin-top: 10px; margin-bottom: 0px; border-style: none; background-color: rgb(238, 238, 238); border-radius: 10px 10px 0px 0px; font-size: large;" onclick="mudaCliente()">Cliente</button>
				<button type="button" id="histDia" style="width: 40%; height: 40px; margin-top: 10px; margin-bottom: 0px; border-style: none; border-radius: 10px 10px 0px 0px; font-size: large; margin-left: 5%; background-color: rgb(187, 187, 187);" onclick="mudahistorico()">Histórico</button>
			</div>
		</div>
		<div class="row" style="min-height: 500px; width: 100%; background-color: rgb(238, 238, 238); display: inherit;" id="clienteMain">
			<div class="col-md-1" style="margin-top: 10px;">
			</div>
			<div style="background-color: white;min-height: 500px;margin-top: 10px;" class="col-md-10">
			<div class="row" id="formnovoticket" style="margin-top: 10px;margin-bottom: 20px;min-height: 100px;text-align: center;padding-top: 10px;">
				<form>
					<div class="col-sm-1">
					</div>
					<?php
					    $nomeTec= "";
					    $spTec = "";
					    if($_GET["numTecnico"]){
					        
					        $sql = "SELECT * FROM `tecnico` WHERE `numero` = ".$_GET["numTecnico"].";";
                            $result = mysqli_query($conn, $sql);
                            
                            
                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $nomeTec= $row["nome"];
					            $spTec = $row["sp"];
                            }else{
                                $nomeTec= "-?-";
					            $spTec = "-?-";
                            }
					    }
					    else{
					        $nomeTec = "Nome do Técnico";
					        $spTec = "Sp do Técnico";
					    }
					    
					    
					    $numConta = "";
					    
					    if($_GET["numconta"]){
					        $numConta = $_GET["numconta"];
					    }else{
					        $numConta = "SXXXXXXXXX";
					    }
					?>
					<div class="col-sm-10" style="background-color: #EEEEEE;border-style: solid;border-width: 1px;border-color: #DDDDDD;border-radius: 10px;">
						<div class="row" style="border-bottom-color: #DDDDDD;border-bottom-style: solid;border-width: 1px;">
							<div style="border-right-color: #DDDDDD;border-right-style: solid;border-width: 1px;" class="col-sm-5">
								<h5><?php echo(utf8_encode($nomeTec));?></h5>
							</div>
							<div style="border-right-color: #DDDDDD;border-right-style: solid;border-width: 1px;" class="col-sm-3">
								<h5><?php echo(utf8_encode($spTec));?></h5>
							</div>
							<div class="col-sm-4">
								<h5><?php echo($numConta);?></h5>
							</div>
						</div>
						<div class="row" style="border-bottom-color: #DDDDDD;border-bottom-style: solid;border-width: 1px;">
							<div class="col-md-4" style="border-right-style: solid;border-right-color: #DDDDDD;border-width: 1px;">
								<input style="text-align: center;width: 90%;border-radius: 10px;border-style: solid;margin-top: 5px;margin-bottom: 3px;" placeholder="Nº OT" type="text">
							</div>
							<div class="col-md-4" style="border-right-style: solid;border-right-color: #DDDDDD;border-width: 1px;">
								<div class="form-group" style="margin-bottom: 0px;">
									<select class="form-control" id="motivoregistro" placeholder="Motivo de registro">
									<option selected="selected">-</option>
										<option>ACTIVAÇÕES</option>
										<option>AUTORIZAÇÃO DE FECHO</option>
										<option>CHAMADA INTERROMPIDA</option>
										<option>DESPISTE EXTERIORES</option>
										<option>FORA ÂMBITO</option>
										<option>MAIL</option>
										<option>OUTROS</option>
										<option>TDC</option>
										<option>TRANSFERÊNCIA DE CHAMADA</option>
										<option>APOIO TÉCNICO</option>
									</select>
								</div> 
							</div>
							<div class="col-md-4">
								<div class="form-group" style="margin-bottom: 0px;">
									<select class="form-control" id="motivoregistro" placeholder="Motivo de registro">
									<option selected="selected">-</option>
										<option>ALARMÍSTICA</option>
										<option>ALTERAÇÕES NA ENCOMENDA</option>
										<option>APOIO TÉCNICO</option>
										<option>APROVISIONAMENTO (ACS/HIT)</option>
										<option>AUDITORES</option>
										<option>AUTORIZADO KO</option>
										<option>AUTORIZADO OK</option>
										<option>CONFIRMAÇÃO DE DIVIDAS</option>
										<option>DESLIGAMENTOS</option>
										<option>EMITIDO</option>
										<option>ENCOMENDA BLOQUEADA/FALHADA</option>
										<option>ERRO SMS ACTIVAÇÃO</option>
										<option>EXTERIORES</option>
										<option>INFORMAÇÕES DE PRÉDIO</option>
										<option>INFORMAÇÕES ENCOMENDA</option>
										<option>INFORMAÇÕES UA</option>
										<option>NÃO AUTORIZADO</option>
										<option>NÃO EMITIDO</option>
										<option>OT FECHADA</option>
										<option>OUTRAS (preencher descrição)</option>
										<option>PEDIDO DE CONTACTOS</option>
										<option>PEDIDO DE FREQUÊNCIAS</option>
										<option>PEDIDO DE SINAIS</option>
										<option>TÉCNICO SEM OT</option>
										<option>TRANSFERÊNCIA MORADA</option>
										<option>PEDIDO DE EXCEPÇÃO</option>
									</select>
								</div> 
							</div>
						</div>
						<div class="row" style="border-width: 1px;text-align: center;border-bottom-style: solid;border-bottom-color: #DDDDDD;">
							<div class="form-group" style="margin-bottom: 0px;">Observações
								<textarea class="form-control" rows="5" id="obs" style="width: 96%;margin-left: 2.5%;height: 50px;margin-top: 5px;margin-bottom: 5px;" placeholder="OBSERVAÇÕES">
								</textarea>
							</div> 
						</div>
						<div class="row" style="border-width: 1px;text-align: center;min-height: 5px;">
							<div class="col-md-3" style="border-right-style: solid;border-right-color: #DDDDDD;border-width: 1px;">
								<input style="text-align: center;width: 65%;border-radius: 10px;border-style: solid;margin-bottom: 3px;" placeholder="Nº Exepção" type="text">
								<button type="button" style="width: 30%;border-style: solid;border-radius: 10px;border-color: #BBBBBB;font-size: small;color: white;background-color: #AAAAAA;text-align: center;">Gerar</button>
							</div>
							<div class="col-md-7" style="border-right-style: solid;border-right-color: #DDDDDD;border-width: 1px;color: gray;font-family: inherit;">
								<label class="checkbox-inline"><input value="exepsinais" id="exepsinais" style="" type="checkbox">Sinais KO</label>
								<label class="checkbox-inline"><input value="exepvod" id="exepvod" type="checkbox">Demo VOD</label>
								<label class="checkbox-inline"><input value="exepvoip" id="exepvoip" type="checkbox">Chamada teste</label>
								<label class="checkbox-inline"><input value="exepspeed" id="exepspeed" type="checkbox">Speed Test</label>
								<label class="checkbox-inline"><input value="exeptdc" id="exeptdc" type="checkbox">TDC</label>
							</div>
							<div class="col-md-2">
								<button type="button" style="width: 80%;border-style: solid;border-radius: 10px;border-color: #BBBBBB;font-size: small;color: white;background-color: #AAAAAA;text-align: center;margin-top: 3px;">Guardar</button>
							</div>
						</div>
						<div class="row" style="border-width: 1px;text-align: center;border-bottom-style: solid;border-bottom-color: #DDDDDD;">
							<div class="form-group" style="margin-bottom: 0px;">Comentário Edist
								<textarea class="form-control" rows="5" id="obs" style="width: 96%;margin-left: 2.5%;height: 50px;margin-top: 5px;margin-bottom: 5px;" placeholder="COMENT_EDIST">
								</textarea>
							</div> 
						</div>
					</div>
					<div class="col-sm-1">
					</div>
				</form>
			</div>
			<div class="row" style="margin-top: 10px;">
				<div class="col-md-1">
				</div>
				<div class="col-md-10" style="min-height: 30px; background-color: rgb(153, 153, 153); border-radius: 10px; border-style: solid; border-color: gray; border-width: 1px; text-align: center; color: white; text-decoration-style: solid; font-size: large;" id="cab1">
					<div class="col-md-3">31/01/2019 17:26</div>
					<div class="col-md-3">Herberto Cardoso</div>
					<div class="col-md-2">Nº Técnico</div>
					<div class="col-md-3">SXXXXXXXXX</div>
					<div class="col-md-1">
						<button type="button" style="border-radius: 10px;border-style: solid;color: black;background-color: #BBBBBB;border-color: #AAAAAA;" onclick="esconderodape('cab1','btn1','rodape1')" id="btn1">+</button>
					</div>
				</div>
				<div class="col-md-1">
				</div>
			</div>
			<div class="row" style="display: none;" id="rodape1">
				<div class="col-md-1">
				</div>
				<div class="col-md-10" style="min-height: 30px;background-color: #EEEEEE;border-color: gray;border-style: solid;border-width: 1px;border-top-width: 0px;border-radius: 0px 0px 10px 10px;">
					<textarea class="form-control" rows="5" id="obs" style="width: 96%;margin-left: 2.5%;height: 100px;margin-top: 5px;margin-bottom: 5px;" placeholder="OBSERVAÇÕES">LAT@I&amp;M - APOIO TÉCNICO - APOIO TÉCNICO:TEC INDICA QUE PLC DA OT NÃO TEM TRAÇADO PORQUE TEM QUE PASSAR PELO MEIO DE VARIAS ARVORES, ALTERADO PARA PLC-YAQ07-093 PORTA 1, | HC@ATEC |
					</textarea>
				</div>
				<div class="col-md-1">
				</div>
			</div>
			<div class="row" style="margin-top: 10px;">
				<div class="col-md-1">
				</div>
				<div class="col-md-10" style="min-height: 30px; background-color: rgb(153, 153, 153); border-radius: 10px; border-style: solid; border-color: gray; border-width: 1px; text-align: center; color: white; text-decoration-style: solid; font-size: large;" id="cab2">
					<div class="col-md-3">31/01/2019 17:12</div>
					<div class="col-md-3">Gabriel Costa</div>
					<div class="col-md-2">Nº Técnico</div>
					<div class="col-md-3">SXXXXXXXXX</div>
					<div class="col-md-1">
						<button type="button" style="border-radius: 10px;border-style: solid;color: black;background-color: #BBBBBB;border-color: #AAAAAA;" onclick="esconderodape('cab2','btn2','rodape2')" id="btn2">+</button>
					</div>
				</div>
				<div class="col-md-1">
				</div>
			</div>
			<div class="row" style="display: none;" id="rodape2">
				<div class="col-md-1">
				</div>
				<div class="col-md-10" style="min-height: 30px;background-color: #EEEEEE;border-color: gray;border-style: solid;border-width: 1px;border-top-width: 0px;border-radius: 0px 0px 10px 10px;">
					<textarea class="form-control" rows="5" id="obs" style="width: 96%;margin-left: 2.5%;height: 100px;margin-top: 5px;margin-bottom: 5px;" placeholder="OBSERVAÇÕES">LAT@I&amp;M - APOIO TÉCNICO - APOIO TÉCNICO:TEC INDICA QUE PLC DA OT NÃO TEM TRAÇADO PORQUE TEM QUE PASSAR PELO MEIO DE VARIAS ARVORES, ALTERADO PARA PLC-YAQ07-093 PORTA 1, | HC@ATEC |
					</textarea>
				</div>
				<div class="col-md-1">
				</div>
			</div>
			<div class="row" style="margin-top: 10px;">
				<div class="col-md-1">
				</div>
				<div class="col-md-10" style="min-height: 30px; background-color: rgb(153, 153, 153); border-radius: 10px; border-style: solid; border-color: gray; border-width: 1px; text-align: center; color: white; text-decoration-style: solid; font-size: large;" id="cab3">
					<div class="col-md-3">31/01/2019 17:08</div>
					<div class="col-md-3">Herberto Cardoso</div>
					<div class="col-md-2">Nº Técnico</div>
					<div class="col-md-3">SXXXXXXXXX</div>
					<div class="col-md-1">
						<button type="button" style="border-radius: 10px;border-style: solid;color: black;background-color: #BBBBBB;border-color: #AAAAAA;" id="btn3" onclick="esconderodape('cab3','btn3','rodape3')">+</button>
					</div>
				</div>
				<div class="col-md-1">
				</div>
			</div>
			<div class="row" style="display: none;" id="rodape3">
				<div class="col-md-1">
				</div>
				<div class="col-md-10" style="min-height: 30px;background-color: #EEEEEE;border-color: gray;border-style: solid;border-width: 1px;border-top-width: 0px;border-radius: 0px 0px 10px 10px;">
					<textarea class="form-control" rows="5" id="obs" style="width: 96%;margin-left: 2.5%;height: 100px;margin-top: 5px;margin-bottom: 5px;" placeholder="OBSERVAÇÕES">LAT@I&amp;M - APOIO TÉCNICO - APOIO TÉCNICO:TEC INDICA QUE PLC DA OT NÃO TEM TRAÇADO PORQUE TEM QUE PASSAR PELO MEIO DE VARIAS ARVORES, ALTERADO PARA PLC-YAQ07-093 PORTA 1, | HC@ATEC |
					</textarea>
				</div>
				<div class="col-md-1">
				</div>
			</div>
			<div class="row" style="margin-top: 10px;">
				<div class="col-md-1">
				</div>
				<div class="col-md-10" style="min-height: 30px; background-color: rgb(153, 153, 153); border-radius: 10px; border-style: solid; border-color: gray; border-width: 1px; text-align: center; color: white; text-decoration-style: solid; font-size: large;" id="cab4">
					<div class="col-md-3">31/01/2019 17:01</div>
					<div class="col-md-3">Carlos Cardoso</div>
					<div class="col-md-2">Nº Técnico</div>
					<div class="col-md-3">SXXXXXXXXX</div>
					<div class="col-md-1">
						<button type="button" style="border-radius: 10px;border-style: solid;color: black;background-color: #BBBBBB;border-color: #AAAAAA;" onclick="esconderodape('cab4','btn4','rodape4')" id="btn4">+</button>
					</div>
				</div>
				<div class="col-md-1">
				</div>
			</div>
			<div class="row" style="display: none;" id="rodape4">
				<div class="col-md-1">
				</div>
			<div class="col-md-10" style="min-height: 30px;background-color: #EEEEEE;border-color: gray;border-style: solid;border-width: 1px;border-top-width: 0px;border-radius: 0px 0px 10px 10px;">
				<textarea class="form-control" rows="5" id="obs" style="width: 96%;margin-left: 2.5%;height: 100px;margin-top: 5px;margin-bottom: 5px;" placeholder="OBSERVAÇÕES">LAT@I&amp;M - APOIO TÉCNICO - APOIO TÉCNICO:TEC INDICA QUE PLC DA OT NÃO TEM TRAÇADO PORQUE TEM QUE PASSAR PELO MEIO DE VARIAS ARVORES, ALTERADO PARA PLC-YAQ07-093 PORTA 1, | HC@ATEC |
				</textarea>
			</div>
			<div class="col-md-1">
			</div>
		</div>
	</div>
	<div class="col-md-1" style="margin-top: 10px;">
	</div>
</div>
<div class="row" style="min-height: 300px; width: 100%; background-color: rgb(238, 238, 238); display: none; text-align: center;" id="historicoMain">
Histórico do dia do operador, tambem colocar uma pesquisa avança para pesquisar ots de dias anteriores
</div>
<div class="row" id="footer" style="height: 50px;width: 100%;background-color: #CCCCCC;"></div>
</div>

</body>
</html>


<?php
mysqli_close($conn);
?>