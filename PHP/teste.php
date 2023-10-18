<?php
  ini_set ( 'display_errors' , 1); 
  error_reporting (E_ALL);

    require "caixa.php";
    $html ="<table>
                <td>ascassa<td>
            </table>";
    gerapdf($html);
?>