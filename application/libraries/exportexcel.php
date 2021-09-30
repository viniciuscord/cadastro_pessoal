<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

include_once("PHPExcel/PHPExcel.php");

class ExportExcel{

	public function export_dados_cadastro($data){
		//print_r(Relatorio_helper::getPerguntas());die();
        if (PHP_SAPI == 'cli')
            die('Esta página é somente para download');
        if (!$data) {
            return false;
        }
		
        $header = array(
		  "Matricula" => "MatriculaSCP",
		  "Nome" => "Nome",
		  "Data Nascimento" => "DataNascimento",
		  "Sexo" => "Sexo",
		  "Mãe Func." => "MaeFuncionario",
		  "Estado Civil" => "EstadoCivil",
		  "Grau Instrução" => "GrauInstrucao",
		  "Email" => "Email",
		  "Quantidade Filhos" => "QuantidadeFilhos",
		  "Telefone 1" => "Telefone1",
		  "Telefone 2" => "Telefone2",
		  "CEP" => "CEP",
		  "Endereço" => "Endereco",
		  "Complemento" => "ComplementoEndereco",
		  "UF" => "UF",
		  "Cidade" => "Cidade",
		  "Bairro" => "Bairro",
		  "CPF" => "CPF",
		  "RG" => "RGFuncionario",
		  "RG Orgão Exp." => "RGOrgaoExpedidor",
		  "RG UF" => "RGUF",
		  "RG Data Exp." => "RGDataExpedicao",
		  "PIS" => "PIS",
		  "CTPS" => "CTPS",
		  "CTPS Serie" => "CTPSSerie",
		  "CTPS Dt. Exp." => "CTPSDataExpedicao",
		  "Id. Banco" => "IdBancoFuncionario",
		  "Banco" => "NomeBanco",
		  "Agência" => "Agencia",
		  "Dig. Agência" => "DigitoAgencia",
		  "Conta" => "Conta",
		  "Dig. Conta" => "DigitoConta",
		  "Tipo de Conta" => "TipoConta",
		  "Operação" => "OperacaoConta",
		  "Nome Empresa" => "NomeEmpresa",
		  "Matrícula Emp." => "MatriculaEmpresa",
		  "CGC" => "CGC",
		  "Nome Lotação" => "NomeLotacao",
		  "Nome Função" => "NomeFuncao",
		  "Data Admissão" => "DataAdmissao",
		  "Matricula Superior" => "MatriculaSuperior",
		  "Horário Início" => "HorarioInicio",
		  "Horário Fim" => "HorarioFim",
		  "Contrato" => "Contrato",
		  "Fila" => "Fila",
		  "Id Fila" => "IdFila",
		  "Situação" => "Situacao"
        );

        $objPHPExcel = new PHPExcel();

        // Create a first sheet, representing sales data
        $objPHPExcel->setActiveSheetIndex(0);
        $header_style = array(
            'font' => array(
                'bold' => true
            ),
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                ),
            )
        );

       // Rename sheet
		$data_plan = date("d_m_Y_H_i");
		$objPHPExcel->getActiveSheet()->setTitle('Relatório_' . $data_plan);
		//$linhas=count($data);
		$l = 0; //linha
		$c = 0; //coluna
		//monta cabeçalho
		foreach ($header as $k => $v) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, 1, $k);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($c, 1)->applyFromArray($header_style);
			$c++;
		}
		//monta linhas
		$l = 1; //linha
		foreach ($data as $k1 => $v1) {
			$c = 0; //coluna atual
			//monta colunas para cada linha
			foreach ($header as $k2 => $v2) {
				$val = $v1[$v2];
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $l + 1, $val);
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($c)->setAutoSize(true);
				$c++;
			}
			$l++;
		}
			
		// Redirect output to a client’s web browser (Excel5)
			
		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment;filename="Relatório_CadAtivos_' . $data_plan . '.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		ob_end_clean();
		ob_start();
		$objWriter->save('php://output');
		return true;

	}

	public function export_dados_frequencia($data){
		//print_r($data[0]);
		//die();
		if (PHP_SAPI == 'cli')
            die('Esta página é somente para download');
        if (!$data) {
            return false;
        }
		//print_r($data);
		//die();
        $header = array(
		  "Dia" => "dia",
		  "Matrícula" => "Matricula",
		  "Nome" => "Nome",
		  "Descrição" => "Descricao",
		  "Entrada Prevista" => "EntradaPrevista",
		  "Entrada Fato" => "EntradaFato",
		  "Entrada Autorizada" => "EntradaAutorizada",
		  "Matrícula Autorização Entrada" => "MatriculaAutorizacaoEntrada",
		  "Saída Prevista" => "SaidaPrevista",
		  "Saída Fato" => "SaidaFato",
		  "Saída Autorizada" => "SaidaAutorizada",
		  "Matríucla Autorização Saída" => "MatriculaAutorizacaoSaida",
		  "Débito" => "Deb1",
		  "Hora Extra" => "Cred",
		);

		$objPHPExcel = new PHPExcel();

        // Create a first sheet, representing sales data
        $objPHPExcel->setActiveSheetIndex(0);
        $header_style = array(
            'font' => array(
                'bold' => true
            ),
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                ),
            )
        );

    	// Rename sheet
		$data_plan = date("d_m_Y_H_i");
		$objPHPExcel->getActiveSheet()->setTitle('Relatório_' . $data_plan);
		//$linhas=count($data);
		$l = 0; //linha
		$c = 0; //coluna
		//monta cabeçalho
		foreach ($header as $k => $v) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, 1, $k);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($c, 1)->applyFromArray($header_style);
			$c++;
		}
		//monta linhas
		$l = 1; //linha
		foreach ($data as $k1 => $v1) {
			$c = 0; //coluna atual
			//monta colunas para cada linha
			foreach ($header as $k2 => $v2) {
				$val = $v1[$v2];
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $l + 1, $val);
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($c)->setAutoSize(true);
				$c++;
			}
			$l++;
		}
			
		// Redirect output to a client’s web browser (Excel5)
			
		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment;filename="Relatorio_Frequencia_' . $data_plan . '.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		ob_end_clean();
		ob_start();
		$objWriter->save('php://output');
		return true;

	}

	public function download_planilha_cadastro(){

		$header = array(
			"Nome" => "Nome",
			"CPF" => "CPF",
			"Data Admissao" => "Data Admissao"
		);
  
		$objPHPExcel = new PHPExcel();
  
		// Create a first sheet, representing sales data
		$objPHPExcel->setActiveSheetIndex(0);
		$header_style = array(
			'font' => array(
				'bold' => true
			),
			'borders' => array(
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_DOUBLE
				),
				'right' => array(
					'style' => PHPExcel_Style_Border::BORDER_DOUBLE
				),
			)
		);

		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('modelo_cadastro');
		$objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);


		//$linhas=count($data);
		$l = 0; //linha
		$c = 0; //coluna
		//monta cabeçalho
		foreach ($header as $k => $v) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, 1, $k);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($c, 1)->applyFromArray($header_style);
			$c++;
		}
		//monta linhas
		$l = 1; //linha
		foreach ($data as $k1 => $v1) {
			$c = 0; //coluna atual
			//monta colunas para cada linha
			foreach ($header as $k2 => $v2) {
				$val = $v1[$v2];
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $l + 1, $val);
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($c)->setAutoSize(true);
				$c++;
			}
			$l++;
		}
			
		// Redirect output to a client’s web browser (Excel5)
			
		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment;filename="modelo_planilha.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		ob_end_clean();
		ob_start();
		$objWriter->save('php://output');
		return true;

	}
	public function exporta_relatorio_ocorrencia_motivo($data){


		$header = array(
			"Data" => "Data",
			"Matrícula Empresa" => "MatriculaEmpresa",
			"Matrícula" => "Mat_CAIXA",
			"Nome" => "Mat_Nome",
			"Função" => "NomeFuncao",
			"Inserido Por" => "Inserido_Por",
			"Ocorrência" => "Ocorrencia",
			"Descrição" => "Motivo_BS",
			"Código BS" => "Cod_BS",
		);
  
		$objPHPExcel = new PHPExcel();
  
		// Create a first sheet, representing sales data
		$objPHPExcel->setActiveSheetIndex(0);
		$header_style = array(
			'font' => array(
				'bold' => true
			),
			'borders' => array(
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_DOUBLE
				),
				'right' => array(
					'style' => PHPExcel_Style_Border::BORDER_DOUBLE
				),
			),
		);

		// Rename sheet
		$data_plan = date("d_m_Y__H:i");
		// $objPHPExcel->getActiveSheet()->setTitle('Relatorio_Ocorrencias_Motivos_' . $data_plan);
		$objPHPExcel->getActiveSheet()->setTitle('Relatorio_Ocorrencias_Motivos');
		$objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);


		//$linhas=count($data);
		$l = 0; //linha
		$c = 0; //coluna
		//monta cabeçalho
		foreach ($header as $k => $v) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, 1, $k);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($c, 1)->applyFromArray($header_style);
			$c++;
		}
		//monta linhas
		$l = 1; //linha
		foreach ($data as $k1 => $v1) {
			$c = 0; //coluna atual
			//monta colunas para cada linha
			foreach ($header as $k2 => $v2) {
				$val = $v1[$v2];
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $l + 1, $val);
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($c)->setAutoSize(true);
				$c++;
			}
			$l++;
		}
			
		// Redirect output to a client’s web browser (Excel5)
			
		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment;filename="Relatorio_Ocorrencias_Motivos_' . $data_plan . '.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		ob_end_clean();
		ob_start();
		$objWriter->save('php://output');
		return true;

	}

	public function exportar_lista_operadores($data){
		
		$header = array(
			"Matrícula" => "Matricula",
			"Nome" => "Login/Nome",
			"Sexo" => "Sexo",
			"Admissão" => "Admissao",
			"Horário" => "Horario",
			"Carga Horária" => "Carga Horaria",
			"Supervisor" => "Supervisor",
			"Função" => "NomeFuncao",
			"Fila" => "Fila",
			"Situação" => "Situacao"
		);
  
		$objPHPExcel = new PHPExcel();
  
		// Create a first sheet, representing sales data
		$objPHPExcel->setActiveSheetIndex(0);
		$header_style = array(
			'font' => array(
				'bold' => true
			),
			'borders' => array(
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_DOUBLE
				),
				'right' => array(
					'style' => PHPExcel_Style_Border::BORDER_DOUBLE
				),
			),
		);

		// Rename sheet
		$data_plan = date("d_m_Y__H:i");
		// $objPHPExcel->getActiveSheet()->setTitle('Relatorio_Ocorrencias_Motivos_' . $data_plan);
		$objPHPExcel->getActiveSheet()->setTitle('Lista_Operadores');
		$objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);


		//$linhas=count($data);
		$l = 0; //linha
		$c = 0; //coluna
		//monta cabeçalho
		foreach ($header as $k => $v) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, 1, $k);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($c, 1)->applyFromArray($header_style);
			$c++;
		}
		//monta linhas
		$l = 1; //linha
		foreach ($data as $k1 => $v1) {
			$c = 0; //coluna atual
			//monta colunas para cada linha
			foreach ($header as $k2 => $v2) {
				$val = $v1[$v2];
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $l + 1, $val);
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($c)->setAutoSize(true);
				$c++;
			}
			$l++;
		}
			
		// Redirect output to a client’s web browser (Excel5)
			
		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment;filename="Lista_Operadores_' . $data_plan . '.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		ob_end_clean();
		ob_start();
		$objWriter->save('php://output');
		return true;

	}

	public function exportar_ocorrencia_detalhado($data){
		//var_dump($data); die;
		$header = array(
			"Data Início" => "DataInicio",
			"Data Fim" => "DataFim",
			"Nome" => "Nome",
			"Função" => "NomeFuncao",
			"Cadastrado por" => "InseridoPor",
			"Motivo" => "Ocorrencia",
			"Justificativa" => "Justificativa"
		);
  
		$objPHPExcel = new PHPExcel();
  
		// Create a first sheet, representing sales data
		$objPHPExcel->setActiveSheetIndex(0);
		$header_style = array(
			'font' => array(
				'bold' => true
			),
			'borders' => array(
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_DOUBLE
				),
				'right' => array(
					'style' => PHPExcel_Style_Border::BORDER_DOUBLE
				),
			),
		);

		// Rename sheet
		$data_plan = date("d_m_Y__H:i");
		// $objPHPExcel->getActiveSheet()->setTitle('Relatorio_Ocorrencias_Motivos_' . $data_plan);
		$objPHPExcel->getActiveSheet()->setTitle('Ocorrencias_Lancadas');
		$objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);


		//$linhas=count($data);
		$l = 0; //linha
		$c = 0; //coluna
		//monta cabeçalho
		foreach ($header as $k => $v) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, 1, $k);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($c, 1)->applyFromArray($header_style);
			$c++;
		}
		//monta linhas
		$l = 1; //linha
		foreach ($data as $k1 => $v1) {
			$c = 0; //coluna atual
			//monta colunas para cada linha
			foreach ($header as $k2 => $v2) {
				$val = $v1[$v2];
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $l + 1, $val);
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($c)->setAutoSize(true);
				$c++;
			}
			$l++;
		}
			
		// Redirect output to a client’s web browser (Excel5)
			
		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment;filename="Ocorrencias_Lancadas_' . $data_plan . '.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		ob_end_clean();
		ob_start();
		$objWriter->save('php://output');
		return true;

	}
	public function export_dados_demanda_ti($data,$mes){

		$header = array(
			"MATRICULA" => "MATRICULA",
			"NOME" => "NOME",
			"FUNÇÃO" => "FUNCAO",
			"TOTAL_HORAS_MES" => "TOTALHORASMES",
			"TOTAL" => "TOTAL",
			"HORA_EXTRA" => "HEXTRA",
			"HORA_NEGATIVA" => "HNEGATIVA",
		);

		$header_2 = array(
			"FUNCAO" => "Funcao",
			"TOTAL" => "Total",
			"TOTAL_POR_FUNCAO" => "TotalPorFuncao",
			"PERCENTUAL" => "Percentual",
			
		);
  
		$objPHPExcel = new PHPExcel();

		// CARREGA OS DADOS DA PLANILHA 2 -- HORAS POR FUNCAO
		$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex(1); //Passar por parâmetro qual planilha definir como ativa

		// Create a first sheet, representing sales data
		$header_style_2 = array(
			'font' => array(
				'bold' => true
			),
			'borders' => array(
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_DOUBLE
				),
				'right' => array(
					'style' => PHPExcel_Style_Border::BORDER_DOUBLE
				),
			),
		);

		// Rename sheet
		$data_plan = date("d_m_Y__H:i");
		// $objPHPExcel->getActiveSheet()->setTitle('Relatorio_Ocorrencias_Motivos_' . $data_plan);
		$objPHPExcel->getActiveSheet()->setTitle('Horas por Funcao_'.$mes);
		$objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);


		//$linhas=count($data);
		$l_2 = 0; //linha
		$c_2 = 0; //coluna
		//monta cabeçalho
		foreach ($header_2 as $k => $v) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_2, 1, $k);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($c_2, 1)->applyFromArray($header_style_2);
			$c_2++;
		}
		//monta linhas
		$l_2 = 1; //linha
		foreach ($data['demandas_por_funcao'] as $k1 => $v1) {
			// print_r($v1);
			// exit();
			$c_2 = 0; //coluna atual
			//monta colunas para cada linha
			foreach ($header_2 as $k2 => $v2) {
				$val_2 = $v1[$v2];
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_2, $l_2 + 1, $val_2);
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($c_2)->setAutoSize(true);
				$c_2++;
			}
			$l_2++;
		}


		// CARREGA OS DADOS DA PLANILHA 1 --- HORAS POR FUNCIONÁRIO
		// Create a first sheet, representing sales data
		$objPHPExcel->setActiveSheetIndex(0);
		$header_style = array(
			'font' => array(
				'bold' => true
			),
			'borders' => array(
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_DOUBLE
				),
				'right' => array(
					'style' => PHPExcel_Style_Border::BORDER_DOUBLE
				),
			),
		);

		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('Horas por Funcionario_'.$mes);
		$objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);


		//$linhas=count($data);
		$l = 0; //linha
		$c = 0; //coluna
		//monta cabeçalho
		foreach ($header as $k => $v) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, 1, $k);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($c, 1)->applyFromArray($header_style);
			$c++;
		}
		//monta linhas
		$l = 1; //linha
		foreach ($data['demandas_por_funcionario'] as $k1 => $v1) {
			$c = 0; //coluna atual
			//monta colunas para cada linha
			foreach ($header as $k2 => $v2) {
				$val = $v1[$v2];
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $l + 1, $val);
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($c)->setAutoSize(true);
				$c++;
			}
			$l++;
		}
			
		// Redirect output to a client’s web browser (Excel5)
			
		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment;filename="Demandas_TI_' . $mes . '.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		ob_end_clean();
		ob_start();
		$objWriter->save('php://output');
		return true;

	}

}

?>
