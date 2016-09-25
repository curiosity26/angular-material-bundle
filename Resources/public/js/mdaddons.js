/**
 * Created by alexboyce on 9/24/16.
 */

angular.module('symfony.mdAddons', ['ngMaterial'])
    .directive('sfAlert', ['$mdToast', '$document', function($mdToast, $document) {
        return {
            restrict: 'E',
            link: function(scope, element, attr) {
                element.addClass('ng-hide');

                var toast = $mdToast.simple();
                toast.action(attr['sfAlertAction'] || 'OK');
                toast.position(attr['sftAlertPosition'] || 'top right');
                toast.capsule(attr['sfAlertCapsule']);
                toast.hideDelay(attr['sfAlertHideDelay'] || 0);
                toast.parent(!!attr['sfAlertParent'] ? $document[0].querySelector(attr['sfAlertParent'])[0] : $document[0].body);
                toast.textContent(element.text());
                toast._options.autoWrap = attr['sfAlertAutoWrap'] == undefined ? true : attr['sfAlertAutoWrap'];
                // Doing the following safely injects the HTML without opening up to XSS vulnerabilities
                toast._options.template ='<md-toast md-theme="{{ toast.theme }}" ng-class="{\'md-capsule\': toast.capsule}">' +
                    '  <div class="md-toast-content">' +
                    '    <span flex role="alert" aria-relevant="all" aria-atomic="true">' +
                    '      ' + element.html() +
                    '    </span>' +
                    '    <md-button class="md-action" ng-if="toast.action" ng-click="toast.resolve()" ng-class="{\'md-highlight\': toast.highlightAction}">' +
                    '      {{ toast.action }}' +
                    '    </md-button>' +
                    '  </div>' +
                    '</md-toast>';

                $mdToast.show(toast);
            }
        };
    }])
    .directive('sfDialogLink', [function() {
        return {
            restrict: 'AC',
            controller: ['$scope', '$mdDialog', '$mdToast', '$element', '$http',
                function($scope, $mdDialog, $mdToast, $element, $http) {
                    var href = $element.attr('href') || $element.attr('ng-href');
                    var method = $element.attr('sfDialogMethod') || 'GET';
                    var data = $element.attr('sfDialogData') || false;
                    var controller = $element.attr('sfDialogController') || function($scope, $mdDialog) {
                            this.closeDialog = function() {
                                $mdDialog.cancel();
                            }
                        };
                    var fullscreen = $element.attr('sfDialogFullscreen') || false;
                    var hasBackdrop = $element.attr('sfDialogHasBackdrop') != false;
                    var escToClose = $element.attr('sfDialogEscapeToClose') != false;
                    var clickOutsideToClose = $element.attr('sfDialogClickOutsideToClose') || false;
                    var disableParentScroll = $element.attr('sfDisableParentScroll') != false;
                    var success = $element.attr('sfDialogSuccess') || false;
                    var cancel = $element.attr('sfDialogCancel') || false;
                    var error = $element.attr('sfDialogError') || false;
                    var options, dialog;

                    $element.on('click', showDialog);

                    function showDialog($event) {
                        if (!!href) {
                            $event.preventDefault();
                            $http({
                                method: method,
                                url: href,
                                data: data,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            }).then(function (response) {
                                options = {
                                    clickOutsideToClose: clickOutsideToClose,
                                    template: '<md-dialog flex-xs="90" flex-gt-xs="70" flex-gt-md="50">' +
                                    '  <md-dialog-content>' +
                                    '     ' + response.data +
                                    '  </md-dialog-content>' +
                                    '</md-dialog>',
                                    scope: $scope,
                                    event: $event,
                                    controller: controller,
                                    controllerAs: 'dialog',
                                    preserveScope: true,
                                    fullscreen: fullscreen,
                                    hasBackdrop: hasBackdrop,
                                    escapeToClose: escToClose,
                                    disableParentScroll: disableParentScroll
                                };

                                $mdDialog.show(options).then(success, cancel);
                            }, function ($err) {
                                if (!!error) {
                                    error($err);
                                }
                                else {
                                    $mdToast.show($mdToast.simple().textContent($err.getMessage()));
                                }
                            });
                        }
                    }
                }]
        };
    }]);