<?php
include "../inc/dbconfig.php";
?>
<div id="popupWindowReport">

            		<div style="background-color:#9DB68C; layer-background-color:#003366;">Report</div>
            		<div style="overflow: hidden;">
                <table width="125" align="center">
                    <tr>
                        <td align="left">										</td>
                    </tr>
                    <tr>
                        <td align="left">&nbsp;</td>
                    </tr>																		
                    <tr>
                        <td align="left"><a href="http://<?php echo $dbHost; ?>/cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/invoice1&amp;aliasname=<?php echo $rpt_alias; ?>&amp;username=admin&amp;password=&amp;ParamMain_ID=<?php echo $id; ?>" target="_blank"> Invoice </a></td>
                    </tr>
                    <tr>
                      <td align="left">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left">&nbsp;</td>
                    </tr>
										                    <tr>
                        <td align="left">&nbsp;</td>
										                    </tr>                    <tr>
                        <td align="left">&nbsp;</td>
										                    </tr>										
                </table>
            		</div>
</div>