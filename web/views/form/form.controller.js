angular
    .module('myApp')
    .controller('FormController',FormController);

FormController.$inject = ["$rootScope", "$scope", "FormService"];

function FormController ($rootScope, $scope, FormService) {

    /**********************/
    /* Private Variables */
    /********************/
    // Freeze the 'this'
    var vm = this;
    var PENDING = "PENDING";

    /**********************/
    /* Public Variables */
    /********************/
    vm.categories;
    vm.subCategories = null;
    vm.dateCombo =[
        {id: "ASAP", text: "As soon posible"},
        {id: "FTM", text: "From 1 to 3 months"},
        {id: "MTM", text: "More than 3 months"}
    ];
    vm.priceCombo =[
        {id: "TH", text: "The cheapest"},
        {id: "VM", text: "Value for Money"},
        {id: "HD", text: "Best Quality"}
    ];
    $scope.date = vm.dateCombo[0];
    $scope.price = vm.priceCombo[0];

    // Controller initialization

    /**********************/
    /*  Private methods  */
    /********************/

    function init () {
        vm.step = 1;
        getCategories();
    }

    function getCategories() {
        FormService.getCategories().then(function (response) {
            $rootScope.categories = response;
            vm.categories = response;
            $scope.category = vm.categories[0];
            getSubCategories($scope.category.id);
        }).catch(function (response) {
            console.log("Bad Request " + response);
        });
    }

    function getSubCategories(id) {
        FormService.getSubCategories(id).then(function (response) {
            $rootScope.subCategories = response;
            vm.subCategories = response;
            $scope.subcategory = vm.subCategories[0];
        }).catch(function (response) {
            console.log("Bad Request " + response);
        })
    }

    function getBudget(id) {
        FormService.getBudget(id).then(function (response) {
            vm.budget = response;
        }).catch(function (response) {
            console.log("Bad Request " + response);
        })
    }

    /**********************/
    /*   Public Methods  */
    /********************/
    vm.prevStep = function () {
        vm.step--;
    };

    vm.nextStep = function () {
        vm.step++;
    };

    vm.setDisabled = function (status) {
        return status === PENDING;
    };
    vm.getSubCategories = getSubCategories;
    vm.getBudget = getBudget;

    /**********************/
    /* Syncronous tasks  */
    /********************/
    init();
}
