<?php

/**
 * Classe com parametros utilizados no sistema
 * 
 */
class ParametrosGerais {
	
	function __construct() {
	}
	
	const qtMesesValidadeSMSPrePago             = 2;
	const idUsuarioAgendaSegura					= -999;
	const statusSucessoSMS						= "000";
	const qtVendasParcela2		          		= 20;
	const qtVendasParcela3		          		= 50;
	const qtVendasSemprePaga				 	= 150;
	const diaPagamentoComissao				 	= 15;
	
	const idIVUsuariosAssinatura				= 1;
	const idIVMesesAssinatura					= 2;
	const idIVSMSAssinatura						= 3;
	const idIVAgendamentosAssinatura			= 4;
	const idIVExibePropagandaAssinatura			= 5;
	const idIVSMSPrePago						= 6;
	const idIVServicosAssinatura				= 7;
	const idIVRelatoriosGerenciaisAssinatura	= 8;
	const idIVAtividadeColetiva					= 9;
	const idIVAtividadeColetivaAssinatura		= 10;
	
	const tipoUsuarioCliente					= "C";
	const tipoUsuarioProfissional				= "P";
	const tipoUsuarioEmpresa					= "E";
	
	const clienteFontColor					= "#ab0f14";
	const profissionalFontColor				= "#8dc63f";
	const empresaFontColor					= "#007b3b";
	
	const emailContato                      = "felipe@sapienzamotos.com.br";
	const dddCelularAdmin                   = "19";
	const numeroCelularAdmin                = "91983486";
		
    public static $arTextosSlideIndex = array(
		);
		
    
	const statusCanceladoPS                     = "Cancelado";
	const statusFinalPagSeguro          		= "Aprovado";
	const statusFinalPagSeguro2          		= "Completo";
	const prazoAdicionalPagSeguro               = 15;
	
}
?>
