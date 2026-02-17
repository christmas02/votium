@forelse($votes as $vote)
    <tr>
        <td>{{ $vote->campagne_nom ?? 'N/A' }}</td>
        <td>{{ $vote->etape_nom ?? 'Global' }}</td>
        
        <td>{{ $vote->quantity ?? 1 }}</td> 
        <td>{{ number_format($vote->montant, 0, ',', ' ') }}</td>
        
        <td>{{ $vote->candidat_nom }} {{ $vote->candidat_prenom }}</td>
        
        <td>{{ \Carbon\Carbon::parse($vote->created_at ?? now())->format('d/m/Y') }}</td>
        
        <td>
            @if($vote->status === 'confirmed')
                <span class="badge bg-success">Confirmé</span>
            @elseif($vote->status === 'created')
                <span class="badge bg-warning">En attente</span>
            @elseif($vote->status === 'rejected')
                <span class="badge bg-danger">Rejeté</span>
            @else
                <span class="badge bg-secondary">{{ $vote->status }}</span>
            @endif
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">Aucun vote trouvé pour cette sélection.</td>
    </tr>
@endforelse