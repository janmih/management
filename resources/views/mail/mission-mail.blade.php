@component('mail::message')
    <h1>Convocation pour une mission</h1>
    <p>Cher/Chère {!! $fullName !!},</p>

    <p>Nous avons le plaisir de vous convier à une mission qui se tiendra du {!! $date_debut !!} au
        {!! $date_fin !!}.</p>

    <p><strong>Lieu de la mission :</strong> {!! $lieu !!}</p>

    <p><strong>Observations :</strong><br>
        {!! $observations !!}</p>

    <p>Nous comptons sur votre présence active et votre contribution pour le succès de cette mission.</p>

    <p><em>N'oublier pas notre cotisation sociale de 10.000 Ariary, qui est à payer auprès de Monsieur José une fois la
            mission
            terminée.</em></p>

    <p>Cordialement,<br>
        {!! config('app.name') !!}</p>
@endcomponent
