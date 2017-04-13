/**
 * Created by a.pinegin on 31.03.17.
 */

var Plugin = {
    init: function () {
        console.log('Plugin');
    }
};

Plugin.init();
console.log('layout');
(function () {
    console.log('header');
})();

