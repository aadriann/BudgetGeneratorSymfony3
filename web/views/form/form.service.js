angular
    .module('myApp')
    .service('FormService',FormService);

FormService.$inject = ["$http"];

// Service
function FormService ($http) {

    // Freeze 'this'
    var vm = this;

    vm.getCategories = getCategories;
    vm.getSubCategories = getSubCategories;
    vm.getBudget = getBudget;

    // Get all activities
    function getCategories () {
        return $http
            .get('http://api.habitissimo.es/category/list/')
            .then(function (response) {
                return response.data;
            });
    }

    function getSubCategories (id) {
        return $http
            .get('http://api.habitissimo.es/category/list/' + id)
            .then(function (response) {
                return response.data;
            });
    }

    function getBudget (id) {
        return $http
            .get('modify/' + id)
            .then(function (response) {
                return response.data;
            });
    }
}
