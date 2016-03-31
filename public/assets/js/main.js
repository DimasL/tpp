$(function () {
    var tpp = new Tpp({});
    tpp.init();
});

var Tpp = function (options) {
    jQuery.extend(this, options);
    var self = this;
    if (!self.hasOwnProperty('container')) {
        self.container = $('#app-layout');
    }
};

Tpp.prototype = {
    init: function () {
        var self = this;
        self.container.find('button.delete-product').on('click', function (e) {
            e.preventDefault();
            self.deleteProduct(this);
        });
        self.container.find('button.delete-user').on('click', function (e) {
            e.preventDefault();
            self.deleteUser(this);
        });
        self.container.find('button.delete-category').on('click', function (e) {
            e.preventDefault();
            self.deleteCategory(this);
        });
        self.container.find('button.delete-subscription').on('click', function (e) {
            e.preventDefault();
            self.deleteSubscription(this);
        });
        self.container.find('button.delete-logs').on('click', function (e) {
            e.preventDefault();
            self.deleteLogs();
        });
        self.container.find('#imgInp').on('change', function (e) {
            e.preventDefault();
            self.readURL(this);
        });
        self.container.find('.delete-image').on('click', function (e) {
            e.preventDefault();
            self.deleteImage(this);
        });
        self.container.find('span.have-children').on('click', function (e) {
            e.preventDefault();
            self.toggleSubcategories(this);
        });
    },
    deleteProduct: function (el) {
        var self = this;
        var deleteProductModal = self.container.find('#deleteProductModal');
        var data = $(el).data();
        deleteProductModal.find('button.delete').data('id', data.id);
        deleteProductModal.find('div.deleteMessage').html('You try to delete the product "' + data.title + '".<br/>Are you sure?');
    },
    deleteUser: function (el) {
        var self = this;
        var deleteUserModal = self.container.find('#deleteUserModal');
        var data = $(el).data();
        deleteUserModal.find('button.delete').data('id', data.id);
        deleteUserModal.find('div.deleteMessage').html('You try to delete the user "' + data.name + '(email: ' + data.email + ')".<br/>Are you sure?');
    },
    deleteCategory: function (el) {
        var self = this;
        var deleteCategoryModal = self.container.find('#deleteCategoryModal');
        var data = $(el).data();
        deleteCategoryModal.find('button.delete').data('id', data.id);
        deleteCategoryModal.find('div.deleteMessage').html('You try to delete the Category "' + data.title + '".<br/>Are you sure?');
    },
    deleteSubscription: function (el) {
        var self = this;
        var deleteSubscriptionModal = self.container.find('#deleteSubscriptionModal');
        var data = $(el).data();
        deleteSubscriptionModal.find('button.delete').data('id', data.id);
        deleteSubscriptionModal.find('div.deleteMessage').html('You try to delete the Subscription "' + data.title + '".<br/>Are you sure?');
    },
    deleteLogs: function () {
        var self = this;
        self.container.find('#deleteLogsModal div.deleteMessage').html('You try to delete all logs.<br/>Are you sure?');
    },
    readURL: function(input) {
        var self = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result).parent().show();
            };
            reader.readAsDataURL(input.files[0]);
            self.container.find('#noImage').val('0');
        }
    },
    deleteImage: function(el) {
        var self = this;
        $(el).parent().hide();
        self.container.find('#noImage').val('1');
        self.container.find('#imgInp').val('');
    },
    toggleSubcategories: function(el) {
        var self = this;
        var id = $(el).attr('data-id');
        self.container.find('li[data-id="' + id + '"]').toggleClass('hide');
    },
};