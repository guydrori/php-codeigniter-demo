<?php $i = 1;?>
<?php if ($this->session->flashdata("newProductSuccess") != null) { echo '<p class="text-success">Product added successfully</p>';}?>
<?php if ($this->session->flashdata("editProductSuccess") != null) { echo '<p class="text-success">Product edited successfully</p>';}?>
<?php if ($this->session->flashdata("deleteProductSuccess") != null) { 
    if ($this->session->flashdata("deleteProductSuccess") == true) {
    echo '<p class="text-success">Product deletion was successful</p>';
    } else {
        echo '<p class="text-success">Product deletion failed</p>';
    }
}?>
<h2>Products</h2>
<table class="text-center table table-striped table-bordered table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Description</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($products as $product) { ?> 
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $product["Name"];?></td>
                <td><?php echo $product["Description"];?></td>
                <td><a href="edit/<?php echo $product["ID"];?>" class="btn btn-warning margin-right">Edit</a> <button onclick="location.href='delete/<?php echo $product["ID"];?>'" class="btn btn-danger">Delete</button></td>
            </trd>
        <?php $i++; } ?>
    </tobdy>
</table>
<a href="new/" class="btn btn-primary margin-right">New product</a>