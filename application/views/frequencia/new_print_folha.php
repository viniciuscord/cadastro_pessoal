<style type="text/css" media="print">
@page {
  /* size: auto; */
  size: auto;
  margin: 0mm;
  /* margin-bottom: 0; */
}

table.page{
    page-break-after: always;
    page-break-inside: avoid;
}

</style>

<style type="text/css">

table {
    border: 1px black;
    border-style: solid;
    border-spacing: 0px;
}

tbody {
    font-size: 10px;
    font-family: Arial;
    text-align: center;
}
td {
    border-bottom: 1px black;
    border-style: solid;
    border-top: 0px;
    border-left: 1px solid black;
    border-right: 0px;

}

th {
    font-family: Arial;
    font-size: 10px;
    text-align: center;
    border-bottom: 1px black;
    border-left: 1px black;
    border-right: 0px black;
    border-style: solid;
    border-top: 0px;

}

.cabecalho {
    font-family: Arial;
    font-size: 10px;
    text-align: left;
    padding: 5px;

}

.ass {
    font-family: Arial;
    font-size: 10px;
    text-align: center;
    padding-bottom: 10px;

}
.text-center{
    padding-left: 10px;
    padding-right: 10px;
}
</style>
<div id="printableArea">
    <?php 
        $count = 0;
        $k=0;
        //print_r($folhas[0]); 
        //die();
        foreach($folhas as $folha): 
    ?> 
    <div class="row">
        <div class="col-sm-12">
        <?php if($count > 0 ): ?>
            <span style="page-break-after:always"></span><br>
        <?php endif; ?>
                <table class="page">
                    <thead>
                        <tr>
                            <th style="border-left: 0px;padding-bottom: 15px;" colspan="13" class="cabecalho">
                            <?php echo strtoupper('Bs Tecnologia e Servicos Ltda<br>
                                    03.655.231/0001-21<br>
                                    R MARCOS PENTEADO OLHOA RODRIGUES 1119, CJ 614, <br>
                                    BARUERI SP<br>');?>
                                <!-- <?php echo strtoupper('Bs Tecnologia e Servicos Ltda<br>
                                        03.655.231/0001-21<br>
                                        R MARCOS PENTEADO OLHOA RODRIGUES,    1119 Conj 614 <br>
                                        BARUERI  SP<br>');?> -->
                            </th>
                            <th style="border-left: 2px solid transparent;">
                                <img src="<?php echo base_url() ?>images/bs-services.png" alt="Logo" height="40"
                                    style="float: right;">
                            </th>
                        </tr>
                        <tr>
                            <th style="border-left: 0px;padding-bottom: 15px;" colspan="14" class="cabecalho">
                                <b>CÓD.:</b> <?php echo $folha[$k]['COD'];?> &nbsp;
                                <b>NOME:</b> <?php echo $folha[$k]['Nome'];?><br>
                                <b>CARGO:</b> <?php echo $folha[$k]['CARGO'];?>
                            </th>
                        </tr>
                        <tr>
                            <th style="border-left: 0px;" class="text-center" rowspan="2">
                                DATA
                            </th>
                            <th rowspan="2">SEM.</th>
                            <th colspan="8" class="text-center">
                                Horário Normal
                            </th>
                            <th colspan="3" class="text-center">
                                Horas Extra
                            </th>
                            <th rowspan="2" class="text-center">Cód. Abono</th>
                        </tr>
                        <tr>
                            <th class="text-center">Entrada</th>
                            <th colspan="2" class="text-center">Intervalo</th>
                            <th colspan="2" class="text-center">Intervalo</th>
                            <th colspan="2" class="text-center">Intervalo</th>
                            <th class="text-center">Saida</th>
                            <th class="text-center">Entrada</th>
                            <th class="text-center" style="padding-left: 15px;padding-right: 15px;">Saida</th>
                            <th class="text-center" style="padding-left: 20px;padding-right: 20px;">Total</th>
                        </tr>
                    </thead>
                <tbody>
                    <?php foreach($folha as $row): ?>
                        <tr>
                            <td style="border-left: 0px; width: 150px;" class="text-center">
                                <?= $row['DATA']; ?>
                            </td>
                            <td  class="text-center" style="width: 150px;">
                                <?= $row['SEM']; ?>
                            </td>
                            <td class="text-center" style="width: 150px;">
                                <?= $row['Entrada'] != null ? $row['Entrada'] : '&nbsp;'; ?>
                            </td>
                            <td  class="text-center" style="width: 150px;">
                                <?= $row['IntervaloEntrada1'] != null ? $row['IntervaloEntrada1'] : '&nbsp;'; ?>
                            </td>
                            <td  class="text-center" style="width: 150px;">
                                <?= $row['SaidaIntervalo1'] != null ? $row['SaidaIntervalo1'] : '&nbsp;'; ?>
                            </td>
                            <td  class="text-center" style="width: 150px;">
                                <?= $row['EntradaAlmoco'] != null ? $row['EntradaAlmoco'] : '&nbsp;'; ?>
                            </td>
                            <td  class="text-center" style="width: 150px;">
                                <?= $row['SaidaAlmoco'] != null ? $row['SaidaAlmoco'] : '&nbsp;'; ?>
                            </td>
                            <td  class="text-center" style="width: 150px;">
                                <?= $row['IntervaloEntrada2'] != null ? $row['IntervaloEntrada2'] : '&nbsp;'; ?>
                            </td>
                            <td  class="text-center" style="width: 150px;">
                                <?= $row['SaidaIntervalo2'] != null ? $row['SaidaIntervalo2'] : '&nbsp;'; ?>
                            </td>
                            <td  class="text-center" style="width: 150px;">
                                <?= $row['Saida'] != null ? $row['Saida'] : '&nbsp;'; ?>
                            </td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td ><?= $row['Cod_Abono'] != null ? $row['Cod_Abono'] : '&nbsp;';?></td>
                        </tr>
                    <?php endforeach; ?>
                    <!-- <tr colspan="14"> -->
                    <tr>
                        <td colspan="14" style="border-left: 0px; border-bottom: 0px;">
                            <table style="border: 0px;">
                                <tbody>
                                    <tr>
                                        <td style="border: 0px;">
                                            <div class="ass" style="padding-top: 35px; padding-left: 10px;">
                                                <span>____________________________________________</span><br>
                                                <span>Assinatura do Colaborador</span><br>
                                                <?php echo $folha[$k]['Nome'];?>
                                            </div>
                                            <div class="ass" style="padding-top: 35px; padding-bottom: 35px; padding-left: 10px;">
                                                <span>____________________________________________</span><br>
                                                <span>Ass. Superior Imediato</span>
                                            </div>
                                        </td>
                                        <td style="border-left: 0px; border-bottom: 0px;"></td>
                                        <td colspan="4" style="padding-top: 25px; padding-left: 25px;border-left: 0px; border-bottom: 0px; padding-bottom: 35px;">
                                            <table style="border-left: 0px; border-bottom: 0px;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4" class="text-center">Cod. Abono</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="border: 0px;">
                                                    <tr>
                                                        <td style="padding: 4px">1</td>
                                                        <td style="padding : 4px">Afastamento</td>
                                                        <td style="padding: 4px">8</td>
                                                        <td style="padding : 4px">Serviço Externo</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px">3</td>
                                                        <td style="padding : 4px">Falta Justif./Atestado</td>
                                                        <td style="padding: 4px">9</td>
                                                        <td style="padding : 4px">Suspensão</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px">4</td>
                                                        <td style="padding : 4px">Feriado</td>
                                                        <td style="padding: 4px">10</td>
                                                        <td style="padding : 4px">A Compensar</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px">5</td>
                                                        <td style="padding : 4px">Férias</td>
                                                        <td style="padding: 4px">11</td>
                                                        <td style="padding : 4px">Compensado</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px">6</td>
                                                        <td style="padding : 4px">Parcial Justificada</td>
                                                        <td style="padding: 4px">12</td>
                                                        <td style="padding : 4px">Desconto Benefício</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px">7</td>
                                                        <td style="padding : 4px">Falta Não Justificada</td>
                                                        <td style="padding: 4px">13</td>
                                                        <td style="padding : 4px">Atraso e Saída Antec.</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="border-left: 0px; border-bottom: 0px;"></td>
                                        <td colspan="4" style="padding-top: 25px; padding-left: 25px; border-left: 0px;border-bottom: 0px; padding-bottom:35px;">
                                            <table style="border-left: 0px; border-bottom: 0px;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4" class="text-center">Uso Exclusivo da BS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="padding: 4px">Adicional Noturno</td>
                                                        <td style="padding-right: 60px; border: 1px solid black;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px">Atrasos</td>
                                                        <td style="padding: 4px; border: 1px solid black;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px">Faltas</td>
                                                        <td style="padding: 4px; border: 1px solid black;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px">HE 100%</td>
                                                        <td style="padding: 4px; border: 1px solid black;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px">VRHE</td>
                                                        <td style="padding: 4px; border: 1px solid black;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 4px">VTHE</td>
                                                        <td style="padding: 4px; border: 1px solid black;">&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <? $count++; ?> 
    <? endforeach; ?>

</div>
</div>