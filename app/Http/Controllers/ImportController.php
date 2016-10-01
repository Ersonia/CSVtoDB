<?php

namespace App\Http\Controllers;
use DB;
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
                                
                                       $CDEM            = $filepart[1] . $filepart[2] . $filepart[3];
                                       $model           = new \App\Bdpb;                                       
                                       $model->CDEM     = $CDEM;
                                       $model->IDGP     = $filepart[2];
                                       $model->IDEN     = $filepart[3];
                                       $model->IDDV     = $filepart[4];
                                       $model->TPPD     = $emapData[0];
                                       $model->ORVT     = $emapData[1];
                                       $model->OFVT     = $emapData[2];
                                       $VEVT            = $filepart[1];
                                       if($VEVT == ''){
                                           $VEVT        = 0;
                                       }
                                       $vmodel          = new \App\Vendedor_vended;
                                       $vmodel->setConnection('mysql2');

                                       $isData = $vmodel::where('ID_Empresa', $VEVT)->where('ID_Grendi', $CDEM)->get();
                                       
                                       if(count($isData) == 0){
                                           $grendi              = new \App\LISEMP;
                                           $grendi->setConnection('mysql2');
                                           $is_count            = $grendi::where('ID_Empresa', $VEVT)->get();
                                           if(count($is_count) == 0){
                                               $grendi              = new \App\LISEMP;
                                                $grendi->setConnection('mysql2');
                                                $grendi->ID_Empresa   = $VEVT;
                                                $grendi->save();
                                           }
                                           
                                           
                                           $grendi              = new \App\GRENDI;
                                           $grendi->setConnection('mysql2');
                                           
                                           $is_count            = $grendi::where('ID_Grendi', $CDEM)->get();
                                           
                                           if(count($is_count) == 0){
                                               $grendi              = new \App\GRENDI;
                                                $grendi->setConnection('mysql2');
                                                $grendi->ID_Grendi   = $CDEM;
                                                $grendi->ID_Empresa   = $VEVT;
                                                $grendi->save();
                                           }
                                           
                                           
                                           $vmodel          = new \App\Vendedor_vended;
                                           $vmodel->setConnection('mysql2');
                                           $vmodel->ID_Empresa          = $VEVT;
                                           $vmodel->ID_Grendi           = $CDEM;
                                           $vmodel->save();
                                           $model->VEVT                 = $vmodel->ID_Vendedor;
                                           echo "Vendor has been saved into database.<br>";
                                       }else{
                                           //echo "<pre>";
                                           //print_r($isData);exit;
                                           $model->VEVT     = $isData[0]->ID_Vendedor;
                                       }
                                       
                                       $model->NRPD     = $emapData[4];
                                       $fdate           = \App\Bdit::convertDate($emapData[5]);
                                       $model->FEPD     = $fdate;
                                       $fdate           = \App\Bdit::convertDate($emapData[6]);
                                       $model->HRPD     = $fdate;
                                       $model->CPPD     = $emapData[7];
                                       $model->OCPD     = $emapData[8];
                                       $fdate           = \App\Bdit::convertDate($emapData[9]);                                       
                                       $model->FCOC     = $fdate;
                                       $fdate           = \App\Bdit::convertDate($emapData[10]);
                                       $model->FVOC     = $fdate;
                                       $fdate           = \App\Bdit::convertDate($emapData[11]);
                                       $model->FPEN     = $fdate;
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
                                       $CUBT            = $emapData[23];
                                      
                                       $soldto          = new \App\Soldto_soldto;
                                       $soldto->setConnection('mysql2');
                                       $isData = $soldto::where('Cuit', $CUBT)->get();
                                       
                                       if(count($isData) == 0){
                                           $vmodel                      = new \App\Soldto_soldto;
                                           $vmodel->setConnection('mysql2');
                                           $vmodel->Cuit                = $CUBT;
                                           $vmodel->save();
                                           $model->CUBT                 = $vmodel->ID_SoldTo;
                                           echo "Soldto_soldto has been saved into database.<br>";
                                       }else{
                                           $model->CUBT     = $isData[0]->ID_SoldTo;
                                       }
                                        
                                       $model->SPPD     = $emapData[24];
                                       $model->DSSP     = $emapData[25];
                                       $model->DRSP     = $emapData[26];
                                       $model->CISP     = $emapData[27];
                                       $model->CPSP     = $emapData[28];
                                       $model->TESP     = $emapData[29];
                                       $model->PASP     = $emapData[30];
                                       $model->INSP     = $emapData[31];
                                       $model->RGSP     = $emapData[32];
                                       $ICPD            = $emapData[34];
                                       $incoterm        = new \App\Incotermsuniversal_incote;
                                       $incoterm->setConnection('mysql2');
                                       $isData = $incoterm::where('ID_Incoterm', $ICPD)->get();
                                       if(count($isData) == 0){
                                           $vmodel                      = new \App\Incotermsuniversal_incote;
                                           $vmodel->setConnection('mysql2');
                                           $vmodel->ID_Incoterm	= $ICPD;
                                           //$vmodel->GRENDI_ID           = $CDEM;
                                           $vmodel->save();
                                           $model->ICPD                 = $vmodel->ID_Incoterm;
                                           echo "Incotermsuniversal has been saved into database.<br>";
                                       }else{
                                           //echo "<pre>";
                                           //print_r($isData);exit;
                                           $model->ICPD     = $isData[0]->ID_Incoterm;
                                       }
                                       //$model->ICPD     = $emapData[34];
                                       $model->LIPD     = $emapData[35];
                                       $model->PESP     = $emapData[36];
                                       $CTSP            = $emapData[37];
                                       $centro          = new \App\Centro_centro;
                                       $centro->setConnection('mysql2');
                                       $isData = $centro::where('ID_Empresa', $CTSP)->where('ID_Grendi', $CDEM)->get();
                                       if(count($isData) == 0){
                                           $grendi              = new \App\LISEMP;
                                           $grendi->setConnection('mysql2');
                                           $isData  = $grendi::where('ID_Empresa', $CTSP)->get();
                                           if(count($isData) == 0){
                                                $grendi              = new \App\LISEMP;
                                                $grendi->setConnection('mysql2');
                                                $grendi->ID_Empresa   = $CTSP;
                                                $grendi->save();
                                           }
                                           
                                           $vmodel                      = new \App\Centro_centro;
                                           $vmodel->setConnection('mysql2');
                                           $vmodel->ID_Empresa  	= $CTSP;
                                           $vmodel->ID_Grendi           = $CDEM;
                                           $vmodel->save();
                                           $model->CTSP                 = $vmodel->ID_Centro;
                                           echo "Centro has been saved into database.<br>";
                                       }else{
                                           //echo "<pre>";
                                           //print_r($isData);exit;
                                           $model->CTSP     = $isData[0]->ID_Centro;
                                       }
                                       //$model->CTSP     = $emapData[37];
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
                                       $fdate           = \App\Bdit::convertDate($emapData[14]);
                                       $model->FEIT     = $fdate;
                                       $fdate           = \App\Bdit::convertDate($emapData[15]);
                                       $model->FPIT     = $fdate;
                                       $model->STIP     = $emapData[16];
                                       $model->ENIT     = $emapData[17];
                                       $model->POEN     = $emapData[18];                                       
                                       $fdate           = \App\Bdit::convertDate($emapData[19]);
                                       $model->FEEN     = $fdate;
                                       $fdate           = \App\Bdit::convertDate($emapData[20]);
                                       $model->HREN     = $fdate;
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
                                       $fdate           = \App\Bdit::convertDate($emapData[35]);
                                       $model->FECE     = $fdate;
                                       $model->HRCE     = $emapData[36];
                                       $model->CPCE     = $emapData[37];
                                       $model->PNCC     = $emapData[38];
                                       $model->PBCC     = $emapData[39];
                                       $model->VOCC     = $emapData[40];
                                       $model->PLCC     = $emapData[41];
                                       $model->ENPG     = $emapData[42];
                                       $fdate           = \App\Bdit::convertDate($emapData[43]);
                                       $model->PGFE     = $fdate;
                                       $fdate           = \App\Bdit::convertDate($emapData[44]);
                                       $model->PGHR     = $fdate;
                                       $model->PGUS     = $emapData[45];
                                       $model->CDEN     = $emapData[46];
                                       $model->ENRE     = $emapData[47];
                                       $fdate           = \App\Bdit::convertDate($emapData[48]);
                                       $model->REFE     = $fdate;
                                       $fdate           = \App\Bdit::convertDate($emapData[49]);
                                       $model->REHR     = $fdate;
                                       $model->REUS     = $emapData[50];
                                       $model->ENFA     = $emapData[51];
                                       $model->ENFE     = $emapData[52];
                                       $model->FATY     = $emapData[53];
                                       $fdate           = \App\Bdit::convertDate($emapData[54]);
                                       $model->FAFE     = $fdate;
                                       $fdate           = \App\Bdit::convertDate($emapData[55]);
                                       $model->FAHR     = $fdate;
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
