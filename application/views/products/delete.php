<h2>Products</h2>
<h3 class="error-text">Are you sure you would like to delete the following product?</h3>
<br/>
<table class= "text-center table table-striped table-bordered table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td><?php echo $product["Name"]?></td>
            <td><?php echo $product["Description"]?></td>
        </tr>
    </tbody>
</table>

<?php echo form_open('products/delete_post',array('id' => 'deleteProductForm'),array('productId'=>$product["ID"]))?>
    <input type="submit" class="btn btn-danger" value="Delete product"/> <a href="javascript:history.back()" class="btn btn-warning" role="button">Back</a>
</form>