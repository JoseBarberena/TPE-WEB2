<?php
/* Smarty version 4.3.4, created on 2023-10-17 22:26:26
  from 'C:\XAAMP\htdocs\Web2-2023\TPE-WEB2\templates\login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_652eedf2c82d12_00765056',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ba3a0bae7304016a1ede826935377ccfcd0dbb2d' => 
    array (
      0 => 'C:\\XAAMP\\htdocs\\Web2-2023\\TPE-WEB2\\templates\\login.tpl',
      1 => 1697574282,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_652eedf2c82d12_00765056 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="container">
  <div class="row mt-4">
    <div class="col-md-4">
      <h2><?php echo $_smarty_tpl->tpl_vars['titulo']->value;?>
</h2>

      <form class="form-alta" action="verify" method="post">
        <div class="row mb-3">
          
          <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" required>
          </div>
        </div>
        <div class="row mb-3">
          
          <div class="col-sm-10">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
          </div>
        </div>
        

        <input type="submit" class="btn btn-primary" value="Login">
        
        
      </form>
    </div>
  </div>
  <div class="row mb-3">
  <h4 class="text-danger"><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</h4>
  </div>
</div>

<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
