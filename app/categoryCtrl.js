app.controller('categoryCtrl', function($scope, $modal, $filter, Data) {
    $scope.product = {};
    Data.get('products').then(function(data) {
        $scope.products = data.data;
    });
    $scope.changeProductStatus = function(product) {
        product.status = (product.status == "Active" ? "Inactive" : "Active");
        Data.put("products/" + product.id, {status: product.status});
    };
    $scope.deleteProduct = function(product) {
        if (confirm("Are you sure to remove the product")) {
            Data.delete("products/" + product.id).then(function(result) {
                $scope.products = _.without($scope.products, _.findWhere($scope.products, {id: product.id}));
            });
        }
    };
    $scope.open = function(p, size) {
        var modalInstance = $modal.open({
            templateUrl: 'partials/productEdit.html',
            controller: 'productEditCtrl',
            size: size,
            resolve: {
                item: function() {
                    return p;
                }
            }
        });
        modalInstance.result.then(function(selectedObject) {
            if (selectedObject.save == "insert") {
                $scope.products.push(selectedObject);
                $scope.products = $filter('orderBy')($scope.products, 'id', 'reverse');
            } else if (selectedObject.save == "update") {
                p.description = selectedObject.description;
                p.price = selectedObject.price;
                p.stock = selectedObject.stock;
                p.packing = selectedObject.packing;
            }
        });
    };

    $scope.columns = [
        {text: "ID", predicate: "id", sortable: true, dataType: "number"},
        {text: "Name", predicate: "name", sortable: true},
        {text: "Price", predicate: "price", sortable: true},
        {text: "Stock", predicate: "stock", sortable: true},
        {text: "Packing", predicate: "packing", reverse: true, sortable: true, dataType: "number"},
        {text: "Description", predicate: "description", sortable: true},
        {text: "Status", predicate: "status", sortable: true},
        {text: "Action", predicate: "", sortable: false}
    ];

});


