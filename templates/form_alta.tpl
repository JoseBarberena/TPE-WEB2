 
 {include file="header.tpl"}

 {* ---Formulario para agregar ventas --- *}

 <div class="dropdown d-flex justify-content-between my-4">
  
 <div>
  
     <form class="row gx-3 gy-2 align-items-center container " action="createSale" method="post">

       <div class="col-sm-3">
         <input type="text" name="cliente" class="form-control" id="specificSizeInputName" placeholder="Cliente" required>
       </div>
       <div class="col-sm-3">
         <input type="text" name="factura" class="form-control" id="specificSizeInputName" placeholder="Factura" required>
       </div>
       <div class="col-sm-3">
         <input type="date" name="fecha" class="form-control" id="specificSizeInputName" placeholder="Fecha" required>
       </div>


       <div class="col-sm-3">
         <label class="visually-hidden" for="specificSizeSelect">Vendedor</label>
        

         <select type="number" class="form-select" id="priority" name="vendedor" value="{$seller->id_Vendedor}">
        
           {foreach from=$sellers item=$seller}
             <option value='{$seller->id_Vendedor}'>{$seller->id_Vendedor} - {$seller->Vendedor}</option>
            
           {/foreach}
         </select>
       </div>

       
       <div class="col-sm-3">
         <input type="text" name="producto" class="form-control" id="specificSizeInputName" placeholder="Producto" required>
       </div>
       <div class="col-sm-3">
         <input type="number" name="cantidad" class="form-control" id="specificSizeInputName" placeholder="Cantidad" required>
       </div>
       <div class="col-sm-3">
         <input type="number" name="p_unitario" class="form-control" id="specificSizeInputName"
           placeholder="P Unitario" required>
       </div>
       <div class="col-sm-3">
         <input type="number" name="total" class="form-control" id="specificSizeInputName" placeholder="Total" required>
       </div>

       <div class="col-auto">
            <button type="submit" class="btn btn-dark">Submit</button>
          </div>

       <div class="col-auto">
        
       </div>
     </form>

   </div>
   
 </div>
 <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <button class="btn btn-outline-secondary"><a class="btn btn-secondary" href="showSales">Return</a></button>
      <button class="btn btn-outline-secondary"><a class="btn btn-secondary" href="home">Home</a></button>
      </div>


      