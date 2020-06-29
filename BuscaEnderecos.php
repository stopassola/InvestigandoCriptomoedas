#!php
<?php
declare(strict_types=1);
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

//Array que armazena as ocorrências globalmente
$todasocorrencias = array();

echo "\u{1F575}  Desenvolvido por Ari Stopassola Junior <ari@perito.inf.br> - versão 0.2.\n"; //Símbolo unicode de alerta

if(!isset($argv[1])){
	echo "\u{26A0} Não foi passado o parâmetro informando o caminho a ser vasculhado.\n"; //Símbolo unicode de alerta
	exit;
}

$caminho = $argv[1];
$dir = new RecursiveDirectoryIterator($caminho);
$dir->setFlags(RecursiveDirectoryIterator::SKIP_DOTS|RecursiveDirectoryIterator::UNIX_PATHS);
$arquivos = new RecursiveIteratorIterator($dir);
$arquivos->setFlags(RecursiveIteratorIterator::SELF_FIRST);
foreach($arquivos as $indice => $arq)
{
	$caminho = $arq->getPathname();
	//echo $caminho."\n";
	$conteudo = file_get_contents($caminho);
	/*
	Bitcoin começa com os dígitos 1 ou 3, possui entre 25 e 34 caracteres
	alfanuméricos (exceptions of 0, O, I, and l) de tamanho, sob o esquema Base58		
	*/
	if(preg_match_all('/[13][a-km-zA-HJ-NP-Z1-9]{24,33}/', $conteudo, $ocorrencias))
	{
		foreach($ocorrencias[0] as $item){
			echo "\u{20BF} "; //Símbolo unicode do Bitcoin
			echo $item."\t\t\t".$caminho."\n";
		}
	}

	/*	
	Endereços Bitcoin Bech32
	Após a string "bc1" haverá de 6 à 90 caracteres, exceto 1, b, i e o.
	*/
	if(preg_match_all('/bc1[ac-hj-np-z02-9]{6,90}/', $conteudo, $ocorrencias))
	{
		foreach($ocorrencias[0] as $item){
			echo "\u{20BF} "; //Símbolo unicode do Bitcoin
			echo $item."\t\t".$caminho."\n";
		}
	}	
	
	/*
	Ethereum começa com 0x e possui 42 caracteres alfanuméricos de tamanho
	*/
	if(preg_match_all('/0x\w{40}/', $conteudo, $ocorrencias))
	{
		foreach($ocorrencias[0] as $item){
			echo "\u{039E} "; //Símbolo unicode do Ethereum
			echo $item."\t\t".$caminho."\n";
		}
	}
	
	/*
	Monero começa com o dígito 4 e possui 94 caracteres
	*/
	if(preg_match_all('/4\w{94}/', $conteudo, $ocorrencias))
	{
		foreach($ocorrencias[0] as $item){
			echo "\u{24C2} "; //Símbolo unicode do Monero
			echo $item."\t".$caminho."\n";
		}
	}
	
}