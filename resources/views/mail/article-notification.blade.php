<x-mail::message>

    <h3>Bonjour {{ $personnel }},</h3>

    Liste des matériels validés :

    @foreach ($materiels_valider as $key => $materiel)
        {{ $key + 1 }}. {{ $materiel['designation'] }} - Quantité: {{ $materiel['quantity'] }}
    @endforeach
    Total des matériels: {{ $materiels_valider->count() }}

    Liste des matériels refusés :

    @foreach ($materiels_refuser as $key => $materiel)
        {{ $key + 1 }}. {{ $materiel['designation'] }} - Quantité: {{ $materiel['quantity'] }}
    @endforeach
    Total des matériels refusés: {{ $materiels_refuser->count() }}

    Veuiller à ne pas répondre svp 🙏🙏


    Cordialement,

</x-mail::message>
