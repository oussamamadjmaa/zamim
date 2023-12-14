import arabic_translations from '../../lang/ar.json';
export default {
    translate (string) {
        return (window._locale == "ar") ? (arabic_translations[string] || string) : string;
    }
}
