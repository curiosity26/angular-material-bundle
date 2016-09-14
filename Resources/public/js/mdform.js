/**
 * Created by alexboyce on 1/7/16.
 */
angular.module('symfony.mdForm', ['ngMaterial'])
    .controller('sfFormController', ['$scope', function($scope) {

        $scope.setRadio = function (e, v) {
            e = v;

            return e;
        };

        $scope.isRadioSelected = function(e, v) {
            return !!e ? e == v : false;
        };

        $scope.toggleCheckbox = function(e, v) {
            var i;

            if (!e) {
                e = [];
            }

            if ((i = e.indexOf(v)) == -1) {
                e.push(v);
            }
            else {
                e.splice(i, 1);
            }

            return e;
        };

        $scope.isChecked = function(e, v) {
            if (!e) {
                return false;
            }
            return e.indexOf(v) > -1;
        };


        $scope.submit = function($event) {
            $event.preventDefault();
        };


    }]);