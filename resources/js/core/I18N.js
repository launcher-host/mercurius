/**
 * Return translation for a given key.
 *
 * Data is loaded from Laravel into `window.Mercurius.i18n`.
 *
 * @param  {string} key  translation key
 * @param  {array} args  attributes used with translations
 * @return {string}
 */
const __ = (key, args) => {
    let trans = _.get(Mercurius.i18n, key);

    _.eachRight(args, (value, key) => {
        trans = trans.replace(':'+key, value);
    });

    return trans;
};


window.__ = __;

Vue.filter('__', (key, args) => {
    return __(key, args);
});


export default __;