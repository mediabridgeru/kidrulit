<?php $iModuleNotActivated = (empty($data['AnyPort']['Activated'])) ? 'no' : $data['AnyPort']['Activated']; ?>
<?php if ($iModuleNotActivated == 'no'){ ?>
<style> .iModuleContent .box .content { display:none } </style>
<script> $('.submitButton').html('Activate'); </script>
<div class="notActivatedContent">
	<h1>AnyPort is not activated.</h1>
	<a href="javascript:void(0)" onclick="$('#form').attr('action',$('#form').attr('action')+'&activate=true'); $('#form').submit();" class="iModuleActivateButton">Activate AnyPort</a>
</div>
<?php } ?>