<?php

?>

<link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/pagination/paginationColor.css">
<link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/pagination/pagination.css">

<div class="row">
    <div class="col-4 px-1">
        <div class="card mb-0">
            <div class="card-body p-1 mb-0 pl-2">
                <form>
                    <div class="form-group mb-1">
                        <select id="selectCustomer" class="border-primary"
                                style="width: 100%; max-width: 100%"></select>
                    </div>
                    <input hidden type="text" id="reference"
                           value="<?= getReference(TABLE_SALES, "date", "INV") ?>">
                    <div class="form-group mb-1">
                        <input type="text" class="form-control border-bottom-3 border-primary" id="saleNote"
                               placeholder="Sale Note">
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table-striped productTable my-0" id="productTable">
                        <thead class="thead-light">
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Remove</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot id="generateFooter">
                        <tr class="table-success">
                            <td>Items</td>
                            <td class="text-right">
                                <span id="itemsType"> </span>
                            </td>
                            <td>Total</td>
                            <td colspan="2" class="text-right">
                                <span id="total"> </span>
                            </td>
                        </tr>
                        <tr class="table-warning">
                            <td colspan="2">Discount</td>
                            <td colspan="3" class="text-right">
                                <input class="updateCalculation" data-id="0" type="number" step="any" min="0"
                                       style="text-align: right; background-color: transparent; border: grey;"
                                       id="orderedDiscount"
                                       name="orderedDiscount">
                            </td>
                        </tr>
                        <tr class="table-primary font-weight-bold">
                            <td colspan="4">Total Payable</td>
                            <td colspan="1" class="text-right">
                                <span id="grandTotal"></span>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 text-center text-white">
            <a href="<?= sysUrl() ?>">
                <button type="button" class="btn btn-sm btn-danger">
                    <p>&nbsp; Cancel &nbsp;</p>
                </button>
            </a>
            <button type="button" class="btn btn-sm btn-warning suspendBtn">
                <p>Suspend</p>
            </button>
            <button type="button" class="btn btn-sm btn-success paymentBtn">
                <p>Payment</p>
            </button>
        </div>
    </div>

    <div class="col-8 px-1">
        <div class="card mb-0" style="background-color: transparent">
            <div class="card-body p-0 mb-1">
                <div class="row">
                    <div class="col-6 pl-4 pr-2">
                        <input style="height: 100%;" class="form-control border-primary text-muted" type="text"
                               id="searchProduct"
                               placeholder="Search by product name">
                    </div>
                    <div class="col-6 pl-2 pr-4">
                        <select name="category" id="selectCategory"
                                class="form-control border-bottom-3 border-primary selectCategory"
                                style="width: 100%; max-width: 100%"></select>
                    </div>
                </div>
                <div class="row mx-1 my-1 mb-3" id="productList"></div>
                <div id="paginationLink"></div>
            </div>
        </div>
    </div>
</div>

<script>
    var newOption = new Option("<?= $posCus->name ?>", <?= $posCus->id ?>, false, false);
    $('#selectCustomer').append(newOption).trigger('change');

    let pickedItem = {id: '', name: '', qty: 0, price: 0, subTotal: 0};
    let sale = {
        items: {},
        grandTotal: 0,
        total: 0,
        discount: 0,
        itemType: 0,
        itemCount: 0,
        customerID: '',
        saleReference: '',
        saleNote: '',
        paymentAmount: 0,
        paymentNote: ''
    };
    var addedProducts = [];

    function addProduct(id, con) {
        let $con = $(con);
        let productID = $con.data('id');
        let productName = $con.data('name');
        let qty = Number(1);
        let price = Number($con.data('price'));
        let sQty = Number($con.data('sqty'));
        var table = document.getElementById("productTable").getElementsByTagName('tbody')[0];
        if (addedProducts.indexOf(id) < 0) {
            var row = table.insertRow();
            row.id = "product" + id;
            row.setAttribute('data-id', id);
            var cell0 = row.insertCell(0);
            var cell1 = row.insertCell(1);
            var cell2 = row.insertCell(2);
            var cell3 = row.insertCell(3);
            var cell4 = row.insertCell(4);
            var cell5 = row.insertCell(5);
            cell0.innerHTML = "<span class='badge badge-primary name'>" + productName + "</span>";
            cell1.innerHTML = "<input data-id='" + id + "' type='number' min='0' step='any' class='text-left discountPrice updateCalculation' value='" + price + "'>";
            cell2.innerHTML = "<input data-id='" + id + "' type = 'number' min='0' max='" + sQty + "' step='any' class='text-left qty updateCalculation' value='" + qty + "'>";
            cell3.innerHTML = "<span class='subtotal updateCalculation'>" + parseFloat((qty * price) + '', 2) + "</span>";
            cell4.innerHTML = "<button type='button' data-id='" + id + "' class='btn btn-sm btnRemove updateCalculation'><i class='fa fa-trash'></i></button>";
            cell5.innerHTML = "<span class='sQty'>" + sQty + "</span>";
            cell5.style.display = "none";
            updateCalculation(row);
            addedProducts.push(id);
        } else {
            let qtT = Number($("#product" + id).find('input.qty').val());
            if (qtT < sQty) {
                $("#product" + id).find('input.qty').val(Number($("#product" + id).find('input.qty').val()) + 1);
                let qt = Number($("#product" + id).find('input.qty').val());
                let discountPrice = Number($("#product" + id).find('input.discountPrice').val());
                $("#product" + id).find('span.subtotal').html(parseFloat((qt * discountPrice) + '', 2));
                qt++;
                updateCalculation($("#product" + id));
            } else {
                $.dialog('<p class="red">No more product in store!!</p>');
            }
        }
    }

    function updateCalculation(target) {
        if (target != undefined) {
            let id = Number($(target).data('id'));
            if (id > 0) {
                let $productRow = $("#product" + id);
                let price = $productRow.find('input.discountPrice').val();
                let qty = $productRow.find('input.qty').val();
                let name = $productRow.find('span.name').text();
                let subTotal = Number(price) * Number(qty);
                $productRow.find('.subtotal').html(subTotal);
                let sQty = Number($productRow.find("span.sQty").html());
                $("#pro" + id).find("span#storage").html(sQty - qty);
                pickedItem = {};
                pickedItem.id = id;
                pickedItem.name = name;
                pickedItem.qty = Number(qty);
                pickedItem.price = Number(price);
                pickedItem.subTotal = subTotal;
                sale.items[id] = pickedItem;
            }
        }
        sale.total = 0;
        sale.discount = $("input#orderedDiscount").val();
        sale.itemType = 0;
        sale.itemCount = 0;
        for (let index in sale.items) {
            let item = sale.items[index];
            sale.total += item.subTotal;
            sale.itemCount += item.qty;
            sale.itemType++;
        }
        $("span#total").html(sale.total);
        $("span#itemsType").html(sale.itemType + " [" + sale.itemCount + "]");
        sale.grandTotal = sale.total - sale.discount;
        $("span#grandTotal").html(sale.grandTotal);
    }

    function savePos(paymentAmount, paymentNote, staffNote) {
        sale.discount = $("input#orderedDiscount").val();
        sale.customerID = $("select#selectCustomer").children("option:selected").val();
        sale.saleReference = $("input#reference").val();
        sale.saleNote = $("input#saleNote").val();
        sale.paymentAmount = paymentAmount;
        sale.paymentNote = paymentNote;
        sale.staffNote = staffNote;
        $.ajax({
            data: sale,
            dataType: 'json',
            method: 'post',
            url: "<?=posUrl('savePos')?>"
        }).done(function (res) {
            window.location.assign("<?=posUrl("invoice/")?>" + res['saleID']);
            //console.log(res['saleID']);
        }).fail(function (err) {
            console.log(err);
        });
    }

    //List Product using selected Category
    loadProducts(1, selectCategory = null, searchProduct = null);

    function loadProducts(page, selectCategory, searchProduct, displayHeight = (screen.height)) {
        $.ajax({
            url: "<?=posUrl("getProducts/") ?>" + page,
            method: "POST",
            dataType: "json",
            data: {selectCategory: selectCategory, searchProduct: searchProduct, displayHeight: displayHeight},
            success: function (data) {
                $('#paginationLink').html(data.paginationLink);
                $('#productList').html(data.productList);
            }
        });
    }

    $(document).ready(function () {
        $("select.selectCategory").change(function () {
            var selectCategory = $(this).children("option:selected").val();
            var searchProduct = $('#searchProduct').val() ? $('#searchProduct').val() : 0;
            loadProducts(1, selectCategory, searchProduct);
        });
        $(document).on('change', "#searchProduct", function (e) {
            var selectCategory = $(".selectCategory").children("option:selected").val() ? $(".selectCategory").children("option:selected").val() : 0;
            var searchProduct = $('#searchProduct').val();
            loadProducts(1, selectCategory, searchProduct);
        });
        $(document).on('keyup', "#searchProduct", function (e) {
            var selectCategory = $(".selectCategory").children("option:selected").val() ? $(".selectCategory").children("option:selected").val() : 0;
            var searchProduct = $('#searchProduct').val();
            loadProducts(1, selectCategory, searchProduct);
        });
        $(document).on('change', ".updateCalculation", function (e) {
            updateCalculation(e.target);
        });
        $(document).on('keyup', ".updateCalculation", function (e) {
            updateCalculation(e.target);
        });

        $('.paymentBtn').on('click', function () {
            if (Number($("select#selectCustomer").children("option:selected").val() != null)) {
                if (Object.keys(sale.items).length > 0) {
                    $.confirm({
                        icon: 'fa fa-shopping-cart',
                        title: "Payment Confirmation!!",
                        theme: 'modern',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        type: 'blue',
                        draggable: true,

                        content: ' ' +
                            '<div class="form-group">' +
                            '<input type="text" placeholder="Payment Note [Optional]" class="form-control border-bottom-3 paymentNote"/>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<input type="text" placeholder="Staff Note [Optional]" class="form-control border-bottom-3 staffNote"/>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<input type="number" step="any" id="gt" class="form-control border-bottom-3 paymentAmount text-center"/>' +
                            '</div>' +
                            '<script> $("input#gt").val(sale.grandTotal)',

                        buttons: {
                            cancel: {
                                btnClass: 'btn-red',
                            },
                            confirm: {
                                btnClass: 'btn-blue',
                                action: function () {
                                    var paymentAmount = Number(this.$content.find('.paymentAmount').val());
                                    var paymentNote = this.$content.find('.paymentNote').val();
                                    var staffNote = this.$content.find('.staffNote').val();
                                    if (!paymentAmount) {
                                        $.alert('<p class="red">Provide a valid amount to make change!</p>');
                                        return false;
                                    } else {
                                        savePos(paymentAmount, paymentNote, staffNote);
                                    }
                                }
                            }
                        }
                    });
                } else {
                    $.dialog('<p class="red">Select Item First!!</p>');
                }
            } else {
                $.dialog('<p class="red">Select Customer First!!</p>');
            }
        });

        $('.suspendBtn').on('click', function () {
            $.confirm({
                icon: 'fa fa-cancel',
                title: "Suspend current sale!!",
                content: "Are you sure to suspend this sale?",
                theme: 'modern',
                autoClose: 'cancel|10000',
                animation: 'scale',
                closeAnimation: 'scale',
                type: 'red',
                buttons: {
                    cancel: {
                        btnClass: 'btn-red',
                    },
                    confirm: {
                        btnClass: 'btn-blue',
                        action: function () {
                            window.open("<?=posUrl()?>", "_blank");
                        }
                    }
                }
            });
        });
    });

    //dynamic pagination
    $(document).on("click", ".pagination li a", function (event) {
        event.preventDefault();
        var page = $(this).data("ci-pagination-page");
        loadProducts(page);
    });

    window.onload = function () {
        $(document).on('click', '.btnRemove', function (e) {
            let id = $(this).data('id').toString();
            $('#product' + id).remove();
            addedProducts.splice(addedProducts.indexOf(id), 1);
            delete sale.items[id];
            updateCalculation();
        });

        $('#selectCustomer').select2({
            placeholder: 'Select Customer',
            ajax: {
                url: '<?=posUrl("selectCustomer")?>',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('#selectCategory').select2({
            placeholder: 'Select Category',
            ajax: {
                url: '<?=posUrl("selectCategory")?>',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('#selectProduct').select2({
            placeholder: 'Select Product',
            ajax: {
                url: '<?=posUrl("selectProduct")?>',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                success: function (data) {
                    //console.log(data);
                },
                cache: true
            }
        });
    }
</script>