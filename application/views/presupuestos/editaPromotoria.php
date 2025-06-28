<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edita Promotoria</title>
    <?php $this->load->view('headers/header'); ?>
   <?php $this->load->view('headers/menu');?>
</head>
<style>
.forma{
    width:750px;
      height:500px;
      margin:0 auto;
    margin-top:5px;
}
  .contenedor{
      width:50rem;
      height:27rem;
      padding:0;
      background-color:#ADADAD;    
  }
  .cont-valor{
    display:grid;
    grid-template-columns: 1fr 2fr;
  }
  .divisor-nombre{
    padding:2rem 2rem;  
     display :block;
    
  }
  .divisor-nombre label{
      color:white;
      font-size:1.5rem;
  }
  .divisor-entrada{
    padding:2rem 2rem;  
    display: flex;
    
  }
  h3{
      text-align:center;
  }
 input {
    flex:1;
  display:block;
  color:black;
}
select {
    flex:1;
  display:block;
  color:black;
}

.buton{
   
    display:flex;  
    justify-content:center;
    width:9rem;
    margin:0 auto;
    margin-top:2rem;

}
.buton input{
    padding:5px 10px;
    background-color:#72F511;
    border:none;   
}
.buton input:hover{
    background-color:#30C5D7 ;
}

</style>

<h3>Edita Promotoria</h3>

 <form method="post" action="<?=base_url()?>cheques/guardaPromotor/" class="forma">
   <div class="contenedor">
   <div class="cont-valor">
      <?
        foreach($companias as $row)
        {?>    
        <input type="hidden" name ="id" value = "<?=$row->idPromotoria?>">
         <div class="divisor-nombre">   
              <label for="nombre">Compañias</label>
         </div>
          <div class="divisor-entrada">
             <input type="text" name ="nombre" value = "<?echo $row->Promotoria?>">
          </div>
        
         <div class="divisor-nombre">
          <label for="Telefono">Telefono</label>  
          </div> 
          <div class="divisor-entrada"> 
          <input type="text" name ="Telefono" value = "<?echo $row->Telefono?>">
          </div>    
          <div class="divisor-nombre">  
          <label for="Correo">Correo</label> 
          </div>     
          <div class="divisor-entrada">    
          <input type="text" name ="Correo" value = "<?echo $row->Correo?>">
          </div>    
          <div class="divisor-nombre"> 
          <label for="Tipo">Aseguradora/Afianzadora</label>
          </div>  
            <div class="divisor-entrada">
           <select name="Tipo" id="Tipo"  value = "<?echo $row->Tipo?>">
           <option value=""></option>
           <option value="SEGURO">SEGURO</option>
           <option value="AFIANZADORA">AFIANZADORA</option>
           </select> 
          
          </div>  
          
         <?
        }
        ?>
     </div>
   </div>
   <div class="buton">
     <input type="submit" name ="grabar" value = "Grabar">
   </div>
 </form>

</html>