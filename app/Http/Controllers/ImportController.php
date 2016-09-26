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
              ini_set('max_execution_time', 0);
             foreach($files as $filename){
                  if($filename != '.' && $filename != '..'){
                    $filepart      = explode("_", $filename);
                    if($filepart[0] == "BDPD"){
                        $file          = fopen("CSV/" . $filename, "r");
                        $count         = 0;
                        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
                        {
                            if( $count != 0 ){
                                
                                        $CDEM   = $filepart[1] . $filepart[2] . $filepart[3];
                                        $model        = new \App\Bdpb;                                       
                                       $model->CDEM     = $CDEM;
                                       $model->IDGP     = $filepart[2];
                                       $model->IDEN     = $filepart[3];
                                       $model->IDDV     = $filepart[4];
                                       $model->TPPD     = $emapData[0];
                                       $model->ORVT     = $emapData[1];
                                       $model->OFVT     = $emapData[2];
                                       $VEVT            = $emapData[3];
                                       $isData = \App\Vendedor_vended::where('Codigo_empresa_ID', $VEVT)->get();
                                       if(count($isData) == 0){
                                           $vmodel                      = new \App\Vendedor_vended;
                                           $vmodel->Codigo_empresa_ID	= $VEVT;
                                           $vmodel->GRENDI_ID           = $CDEM;
                                           $vmodel->save();
                                           $model->VEVT                 = $vmodel->id;
                                           echo "Vendor has been saved into database.<br>";
                                       }else{
                                           //echo "<pre>";
                                           //print_r($isData);exit;
                                           $model->VEVT     = $isData[0]->ID_Vendedor;
                                       }
                                       
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
                            }  
                            $count++;    
                        }
                         fclose($file);
                         rename('CSV/' . $filename, 'importedCSV/' . $filename);  
                    }else if($filepart[0] == "BDIT"){
                        
                        $file          = fopen("CSV/" . $filename, "r");
                        
                        $count         = 0;
                        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
                        {
                            if( $count != 0 ){
                                 
                                
                                        
                                        $model        = new \App\Bdit;                                       
                                       
                                       //$model->NRPD     = $emapData[0];
                                       $model->POIT     = $emapData[1];
                                       $model->MTPD     = $emapData[2];
                                       $model->DSMT     = $emapData[3];
                                       //$model->13MT     = $emapData[4];
                                       //$model->14MT     = $emapData[5];
                                       $model->CPIT     = $emapData[6];
                                       $model->UMIT     = $emapData[7];
                                       $model->PNIT     = $emapData[8];
                                       $model->PBIT     = $emapData[9];
                                       $model->VOIT     = $emapData[10];
                                       $model->VLIT     = $emapData[11];
                                       $model->MOIT     = $emapData[12];
                                       $model->PLIT     = $emapData[13];
                                       $model->CEIT     = $emapData[14];
                                       $model->FEIT     = $emapData[15];
                                       $model->STIP     = $emapData[16];
                                       $model->ENIT     = $emapData[17];
                                       $model->POEN     = $emapData[18];                                       
                                       $model->FEEN     = $emapData[19];
                                       $model->HREN     = $emapData[20];
                                       $model->CPEN     = $emapData[21];
                                       $model->CTEN     = $emapData[22];
                                       $model->STIT     = $emapData[23];
                                       $model->BQEN     = $emapData[24];
                                       $model->DSBQ     = $emapData[25];
                                       $model->BQFA     = $emapData[26];
                                       $model->DSBF     = $emapData[27];
                                       $model->MTEN     = $emapData[28];
                                       $model->DSEN     = $emapData[29];
                                       //$model->13EN     = $emapData[30];
                                       //$model->14EN     = $emapData[31];                                        
                                       //$model->CPCP     = $emapData[32];
                                       $model->SHID     = $emapData[33];
                                       $model->CCEN     = $emapData[34];
                                       $model->FECE     = $emapData[35];
                                       $model->HRCE     = $emapData[36];
                                       $model->CPCE     = $emapData[37];
                                       $model->PNCC     = $emapData[38];
                                       $model->PBCC     = $emapData[39];
                                       $model->VOCC     = $emapData[40];
                                       $model->PLCC     = $emapData[41];
                                       $model->ENPG     = $emapData[42];
                                       $model->PGFE     = $emapData[43];
                                       $model->PGHR     = $emapData[44];
                                       $model->PGUS     = $emapData[45];
                                       $model->CDEN     = $emapData[46];
                                       $model->ENRE     = $emapData[47];
                                       $model->REFE     = $emapData[48];
                                       $model->REHR     = $emapData[49];
                                       $model->REUS     = $emapData[50];
                                       $model->ENFA     = $emapData[51];
                                       $model->ENFE     = $emapData[52];
                                       $model->FATY     = $emapData[53];
                                       $model->FAFE     = $emapData[54];
                                       $model->FAHR     = $emapData[55];
                                       $model->FAUS     = $emapData[56];
                                       $model->CTFA     = $emapData[57];
                                       $model->PNFA     = $emapData[58];
                                       $model->PBFA     = $emapData[59];
                                       $model->VOFA     = $emapData[60];
                                       $model->VLFA     = $emapData[61];
                                       $model->PLFA     = $emapData[62];
                                      
                                       
                                       $is_saved        = $model->save();
                                       if($is_saved){
                                           echo "data for file " . $filepart[0] . " has been saved. <br>";
                                           $isData = \App\Mercaderia_lismat::where('Sku', $model->MTPD)->get();
                                           if(count($isData) == 0){
                                               $model1                  = new \App\Mercaderia_lismat;   
                                                $model1->Sku             = $model->MTPD;
                                                $model1->Descripcion     = $model->DSMT;
                                                $model1->UOM             = $model->UMIT;
                                                $PesoNeto                = $model->PNIT / $model->CPIT;
                                                $model1->PesoNeto        = $PesoNeto;
                                                $model1->PesoBruto       = $model->MTPD;
                                                $Volumen                 = $model->VOIT / $model->CPIT;
                                                $model1->Volumen         = $Volumen;
                                                $CantxPallet             = $model->PLIT / $model->CPIT;
                                                $model1->CantxPallet     = $CantxPallet;
                                                $is_saved   = $model1->save();
                                                if($is_saved){
                                                    echo "New SKU has been Saved.<br>";
                                                }
                                           }
                                           
                                       }else{
                                           echo "Not Saved";
                                       }
                                  
                              
                                
                            }  
                            $count++;    
                            
                        }
                            fclose($file);
                            rename('CSV/' . $filename, 'importedCSV/' . $filename);  
                    }else if($filepart[0] == "BDSH"){
                        $file          = fopen("CSV/" . $filename, "r");
                        $count         = 0;
                        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
                        {
                            if( $count != 0 ){
                                        
                                       $model        = new \App\Bdsh;                                       
                                       
                                       $model->TTEN     = $emapData[0];
                                       $model->FETT     = $emapData[1];
                                       $model->HRTT     = $emapData[2];
                                       $model->CPTT     = $emapData[3];
                                       //$model->PTTT     = $emapData[4];
                                       $model->TTET     = $emapData[5];
                                       $model->ETDS     = $emapData[6];
                                       $model->ETDR     = $emapData[7];
                                       //$model->ETLO     = $emapData[8];
                                       $model->ETCP     = $emapData[9];
                                       $model->ETPA     = $emapData[10];
                                       $model->ETTE     = $emapData[11];
                                       $model->ETCU     = $emapData[12];
                                       
                                       $is_saved        = $model->save();
                                       if($is_saved){
                                           echo "data for file " . $filepart[0] . " has been saved. <br>";
                                       }else{
                                           echo "Not Saved";
                                       }
                                  
                              
                            }  
                            $count++;    
                        }
                        fclose($file);
                        rename('CSV/' . $filename, 'importedCSV/' . $filename);  
                    }  
                   
                  }  
             }
    }
    
}
