function nombreEnLettre(nombre) {
    const unites = ['', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf'];
    const dizaines = ['', 'dix', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante-dix', 'quatre-vingt', 'quatre-vingt-dix'];
    const dizainesFeminin = ['onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf'];

    if (nombre === 0) return 'zéro';
    if (nombre < 10) return unites[nombre];

    if (nombre >= 11 && nombre <= 19) {
        return dizainesFeminin[nombre - 11];
    }

    const unite = nombre % 10;
    const dizaine = Math.floor(nombre / 10);

    if (unite === 0) {
        return dizaines[dizaine];
    } else if (dizaine === 7 || dizaine === 9) {
        return dizaines[dizaine] + '-' + unites[unite];
    } else {
        return dizaines[dizaine] + '-' + unites[unite];
    }
}