var DTOx = angular.module('DTOx', ['ui']);

DTOx.value('ui.config', {
    codemirror: {
        mode: 'text/x-php',
        lineNumbers: true,
        matchBrackets: true,
        theme: 'vibrant-ink'
    }
});

function DTOCtrl($scope, $timeout, $http) {
    $scope.dto = {
        vars: []
    };

    $scope.change = function () {
        var prom = 0;
        $timeout.cancel(prom);
        prom = $timeout(function () {
            $http.post('/dto/', angular.toJson($scope.dto)).success(function (data) {
                var returnData = angular.fromJson(data);
                $scope.code = {
                    dto: returnData.dto,
                    test: returnData.test
                };
            });
        }, 1000);
    };

    $scope.addVar = function () {
        $scope.dto.vars.push({
            name: $scope.varName,
            type: $scope.varType,
            testData: $scope.varTestData
        });
        $scope.varName = '';
        $scope.varType = '';
        $scope.varTestData = '';
        $scope.change();
    };
}
