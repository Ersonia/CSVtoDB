<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class ImportController extends Controller
{
     
    public function getIndex(){
             //$filename      = "CSV/BDPD_0103_040916_1525_0916.csv";
             $files         = scandir("CSV");
             foreach($files as $filename){
                    $filepart      = explode("_", $filename);
                    if($filepart[0] == "BDPD"){
                        $file          = fopen("CSV/" . $filename, "r");
                        $count         = 0;
                        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
                        {
                            if( $count != 0 ){
                                $isData = \App\Bdpb::where('CDEM', $filepart[1])
                                                ->where('IDGP', $filepart[2])
                                                ->where('IDEN', $filepart[3])
                                                ->where('IDDV', $filepart[4])
                                                ->where('TPPD', $emapData[0])
                                                ->where('ORVT', $emapData[1])
                                                ->where('OFVT', $emapData[2])
                                                ->where('VEVT', $emapData[3])
                                                ->where('NRPD', $emapData[4])
                                                ->where('FEPD', $emapData[5])
                                                ->where('HRPD', $emapData[6])
                                                ->where('CPPD', $emapData[7])
                                                ->where('OCPD', $emapData[8])
                                                ->where('FCOC', $emapData[9])
                                                ->where('FVOC', $emapData[10])
                                                ->where('FPEN', $emapData[11])
                                                ->where('STPD', $emapData[12])
                                                ->where('DSST', $emapData[13])
                                                ->where('DRST', $emapData[14])
                                                ->where('CIST', $emapData[15])
                                                ->where('CPST', $emapData[16])
                                                ->where('TEST', $emapData[17])
                                                ->where('PAST', $emapData[18])                                                
                                                ->where('DSPY', $emapData[20])
                                                ->where('BTPD', $emapData[21])
                                                ->where('DSBT', $emapData[22])
                                                ->where('CUBT', $emapData[23])
                                                ->where('SPPD', $emapData[24])
                                                ->where('DSSP', $emapData[25])
                                                ->where('DRSP', $emapData[26])
                                                ->where('CISP', $emapData[27])
                                                ->where('CPSP', $emapData[28])
                                                ->where('TESP', $emapData[29])
                                                ->where('PASP', $emapData[30])
                                                ->where('INSP', $emapData[31])
                                                ->where('RGSP', $emapData[32])                                                 
                                                ->where('ICPD', $emapData[34])
                                                ->where('LIPD', $emapData[35])
                                                ->where('PESP', $emapData[36])
                                                ->where('CTSP', $emapData[37])
                                                ->where('DSCT', $emapData[38])
                                                ->where('UNPD', $emapData[39])
                                                ->where('UMPD', $emapData[40])
                                                ->where('PNPD', $emapData[41])
                                                ->where('PBPD', $emapData[42])
                                                ->where('VOPD', $emapData[43])
                                                ->where('VLPD', $emapData[44])
                                                ->where('MOPD', $emapData[45])
                                                ->where('PLPD', $emapData[46])
                                                ->where('STEN', $emapData[47])->get();
                                
                              if( count($isData ) == 0 ){
                                        $model        = new \App\Bdpb;                                       
                                       $model->CDEM     = $filepart[1];
                                       $model->IDGP     = $filepart[2];
                                       $model->IDEN     = $filepart[3];
                                       $model->IDDV     = $filepart[4];
                                       $model->TPPD     = $emapData[0];
                                       $model->ORVT     = $emapData[1];
                                       $model->OFVT     = $emapData[2];
                                       $model->VEVT     = $emapData[3];
                                       $model->NRPD     = $emapData[4];
                                       $model->FEPD     = $emapData[5];
                                       $model->HRPD     = $emapData[6];
                                       $model->CPPD     = $emapData[7];
                                       $model->OCPD     = $emapData[8];
                                       $model->FCOC     = $emapData[9];
                                       $model->FVOC     = $emapData[10];
                                       $model->FPEN     = $emapData[11];
                                       $model->STPD     = $emapData[12];
                                       $model->DSST     = $emapData[13];
                                       $model->DRST     = $emapData[14];
                                       $model->CIST     = $emapData[15];
                                       $model->CPST     = $emapData[16];
                                       $model->TEST     = $emapData[17];
                                       $model->PAST     = $emapData[18];                                       
                                       $model->DSPY     = $emapData[20];
                                       $model->BTPD     = $emapData[21];
                                       $model->DSBT     = $emapData[22];
                                       $model->CUBT     = $emapData[23];
                                       $model->SPPD     = $emapData[24];
                                       $model->DSSP     = $emapData[25];
                                       $model->DRSP     = $emapData[26];
                                       $model->CISP     = $emapData[27];
                                       $model->CPSP     = $emapData[28];
                                       $model->TESP     = $emapData[29];
                                       $model->PASP     = $emapData[30];
                                       $model->INSP     = $emapData[31];
                                       $model->RGSP     = $emapData[32];                                        
                                       $model->ICPD     = $emapData[34];
                                       $model->LIPD     = $emapData[35];
                                       $model->PESP     = $emapData[36];
                                       $model->CTSP     = $emapData[37];
                                       $model->DSCT     = $emapData[38];
                                       $model->UNPD     = $emapData[39];
                                       $model->UMPD     = $emapData[40];
                                       $model->PNPD     = $emapData[41];
                                       $model->PBPD     = $emapData[42];
                                       $model->VOPD     = $emapData[43];
                                       $model->VLPD     = $emapData[44];
                                       $model->MOPD     = $emapData[45];
                                       $model->PLPD     = $emapData[46];
                                       $model->STEN     = $emapData[47];
                                       $is_saved        = $model->save();
                                       if($is_saved){
                                           echo "data for file " . $filepart[0] . " has been saved. <br>";
                                       }else{
                                           echo "Not Saved";
                                       }
                                  
                              }else{
                                  echo "am here";
                              }  
                                
                            }  
                            $count++;    
                        }
                        fclose($file);
                    }                    
             }
    }
    
}
