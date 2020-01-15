<div class="span6 pull-left" style="margin: 0 10px 20px 0;">
	<div class="control-group form-horizontal">
		<form class="form-horizontal">
			<div class="control-group">
				<label class="control-label" style="width: 138px;"><?php echo $text_common_seo_breadcrumb_1; ?></label>
				<?php $mode = $data['tools']['seo_breadcrumbs']['data']['product']['mode']; ?>
				<div class="controls radioControllValue" style="margin-left: 155px;">
					<div class="btn-group" data-toggle="buttons-radio">
						<a type="button" data-action="save" data-scope=".parents('.controls').find('input')" data-condition="direct" class="btn btn-success <?php if($mode == 'direct') echo "active"; ?>" data-toggle="tooltip" data-original-title="Set direct path for breadcrumbs" >
						<?php echo $text_common_direct; ?></a>
						<a type="button" data-action="save" data-scope=".parents('.controls').find('input')" data-condition="shortest" class="btn btn-success <?php if($mode == 'shortest') echo "active"; ?>" data-toggle="tooltip" data-original-title="Set shortest path for breadcrumbs" >
						<?php echo $text_common_shortest; ?></a>
						<a type="button" data-action="save" data-scope=".parents('.controls').find('input')" data-condition="longest" class="btn btn-success <?php if($mode == 'longest') echo "active"; ?>" data-toggle="tooltip" data-original-title="Set largest path for breadcrumbs" >
						<?php echo $text_common_longest; ?></a>
						<a type="button" data-action="save" data-scope=".parents('.controls').find('input')" data-condition="default" class="btn <?php if($mode == 'default') echo "active"; ?>" data-toggle="tooltip" data-original-title="Set defaul path for breadcrumbs" >
						<?php echo $text_common_default; ?></a>
					</div>
					<input type="hidden" name="data[tools][seo_breadcrumbs][data][product][mode]" value="<?php echo $mode; ?>">
				</div>
			</div>
		</form>
	</div>
	
	<div class="control-group form-horizontal">
		<form class="form-horizontal">
			<div class="control-group">
				<label class="control-label" style="width: 138px;"><?php echo $text_common_seo_breadcrumb_2; ?></label>
				<?php $mode = $data['tools']['seo_breadcrumbs']['data']['category']['mode']; ?>
				<div class="controls radioControllValue" style="margin-left: 155px;">
					<div class="btn-group" data-toggle="buttons-radio">
						<a type="button" data-action="save" data-scope=".parents('.controls').find('input')" data-condition="direct" class="btn btn-success <?php if($mode == 'direct') echo "active"; ?>" data-toggle="tooltip" data-original-title="Set direct path for breadcrumbs" >
						<?php echo $text_common_direct; ?></a>
						<a type="button" data-action="save" data-scope=".parents('.controls').find('input')" data-condition="shortest" class="btn btn-success <?php if($mode == 'shortest') echo "active"; ?>" data-toggle="tooltip" data-original-title="Set shortest path for breadcrumbs" >
						<?php echo $text_common_shortest; ?></a>
						<a type="button" data-action="save" data-scope=".parents('.controls').find('input')" data-condition="full" class="btn btn-success <?php if($mode == 'full') echo "active"; ?>" data-toggle="tooltip" data-original-title="Set shortest path for breadcrumbs" >
						<?php echo $text_common_full; ?></a>
						<a type="button" data-action="save" data-scope=".parents('.controls').find('input')" data-condition="default" class="btn <?php if($mode == 'default') echo "active"; ?>" data-toggle="tooltip" data-original-title="Set defaul path for breadcrumbs" >
						<?php echo $text_common_default; ?></a>
					</div>
					<input type="hidden" name="data[tools][seo_breadcrumbs][data][category][mode]" value="<?php echo $mode; ?>">
				</div>
			</div>
		</form>
	</div>

	<div class="row">
		<div class="span3">
			<div class="control-group">
				<label class="control-label"><?php echo $text_common_seo_breadcrumb_3; ?></label>
				<div class="controls">
					<input type="hidden" name="data[tools][seo_breadcrumbs][data][product][reverse]" value="">
					<input data-action="save" data-scope=".parents('.controls').find('input')" type="checkbox" value="true" <?php if($data['tools']['seo_breadcrumbs']['data']['product']['reverse']) echo 'checked="checked"'; ?> name="data[tools][seo_breadcrumbs][data][product][reverse]" class="on_off">
				</div>
			</div>	
		</div>
		<div class="span3">
			<div class="control-group">
				<label class="control-label"><?php echo $text_common_seo_breadcrumb_4; ?></label>
				<div class="controls">
					<input type="hidden" name="data[tools][seo_breadcrumbs][data][category][reverse]" value="">
					<input data-action="save" data-scope=".parents('.controls').find('input')" type="checkbox" value="true" <?php if($data['tools']['seo_breadcrumbs']['data']['category']['reverse']) echo 'checked="checked"'; ?> name="data[tools][seo_breadcrumbs][data][category][reverse]" class="on_off">
				</div>
			</div>		
		</div>
	</div>
	<div class="row">
		<div class="span3">
			<div class="control-group">
				<label class="control-label"><?php echo $text_common_seo_breadcrumb_5; ?></label>
				<div class="controls">
					<input type="hidden" name="data[tools][seo_breadcrumbs][data][additional][title]" value="">
					<input data-action="save" data-scope=".parents('.controls').find('input')" type="checkbox" value="true" <?php if($data['tools']['seo_breadcrumbs']['data']['additional']['title']) echo 'checked="checked"'; ?> name="data[tools][seo_breadcrumbs][data][additional][title]" class="on_off">
				</div>
			</div>
		</div>
		<div class="span3">
			<div class="control-group">
				<label class="control-label"><?php echo $text_common_seo_breadcrumb_6; ?></label>
				<div class="controls">
					<input type="hidden" name="data[tools][seo_breadcrumbs][data][additional][home_to_store]" value="">
					<input data-action="save" data-scope=".parents('.controls').find('input')" type="checkbox" value="true" <?php if($data['tools']['seo_breadcrumbs']['data']['additional']['home_to_store']) echo 'checked="checked"'; ?> name="data[tools][seo_breadcrumbs][data][additional][home_to_store]" class="on_off">
				</div>
			</div>	
		</div>
	</div>	
</div>

<h3><?php echo $text_common_seo_breadcrumb_7; ?></h3>

<p><?php echo $text_common_seo_breadcrumb_8; ?>:
<ul>
	<?php echo $text_common_seo_breadcrumb_9; ?>
</ul>

<p style="clear:both;"><?php echo $text_common_seo_breadcrumb_10; ?>:
<pre>Home >> Product name</pre>
<?php echo $text_common_seo_breadcrumb_11; ?>:
<pre>Home >> Category >> Product name</pre>
<?php echo $text_common_seo_breadcrumb_12; ?></p>

<h4>You can set the next mode for creating breadcrumb:</h4>
<dl>
	<dt><?php echo $text_common_direct; ?></dt>
	<dd>
		<?php echo $text_common_path_manager_8; ?>:
		<pre>home >> product_name</pre>
	</dd>
	<dt><?php echo $text_common_shortest; ?></dt>
	<dd>
		<?php echo $text_common_path_manager_9; ?>:
		<pre>home >> category_X >> subcategory_Y >> product_name
home >> category_Z >> product_name</pre>
		<?php echo $text_common_path_manager_10; ?>  <pre>home >> category_Z >> product_name</pre>
		Also, if you set this mode for category, and , for example, you have the next category link:
		<pre>home >> category_1 >> category_2 >> category_3 >> category_4</pre>
		That link will be transforms to <pre>home >> category_1 >> category_4</pre>As you see,- link will be created from first category and last category
	</dd>
	<dt><?php echo $text_common_longest; ?></dt>
	<dd>
		<?php echo $text_common_path_manager_11; ?>:
		<pre>home >> category_X >> subcategory_Y >> product_name
home >> category_Z >> product_name</pre>
		<?php echo $text_common_path_manager_12; ?>  <pre>home >> category_X >> subcategory_Y >> product_name</pre>
	</dd>
	<dt><?php echo $text_common_last_category; ?> (only for products)</dt>
	<dd>
		<?php echo $text_common_path_manager_121; ?>
		<pre>home >> category_X >> categoty_Y >> category_Z >> product_name</pre>
		<?php echo $text_common_path_manager_122; ?>
		<pre>home >> category_Z >> product_name</pre>
	</dd>
	<dt><?php echo $text_common_first_category; ?> (only for products)</dt>
	<dd>
		<?php echo $text_common_path_manager_123; ?>
		<pre>home >> category_X >> categoty_Y >> category_Z >> product_name</pre>
		<?php echo $text_common_path_manager_122; ?>
		<pre>home >> category_X >> product_name</pre>
	</dd>
	<dt><?php echo $text_common_full; ?> (only for categories)</dt>
	<dd>
		<?php echo $text_common_path_manager_13; ?>:
		<pre>home >> category_X >> subcategory_Y >> subcategory_Z
home >> category_Z</pre>
		<?php echo $text_common_path_manager_14; ?>  <pre>home >> category_X >> subcategory_Y >> subcategory_Z</pre>
	</dd>
	<dt><?php echo $text_common_default; ?></dt>
	<dd>
		<?php echo $text_common_path_manager_15; ?>
	</dd>
</dl>

<h4><?php echo $text_common_seo_breadcrumb_13; ?></h4>
<p>
<?php echo $text_common_seo_breadcrumb_14; ?>:
<pre>Product name >> Category >> Home</pre> 
</p>
<p><?php echo $text_common_seo_breadcrumb_15; ?>:
<pre>Product name << Category << Home | Store Title </pre> 
</p>
<p><?php echo $text_common_seo_breadcrumb_16; ?>:
<pre>Product name >> Category >> Store name </pre> 
</p>

<script>
	function setRadiobuttonValue(){
		
	}
</script>