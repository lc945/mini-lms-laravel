@extends('layouts.app')
@section('title', 'Mes Notes')
@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">📊 Mes Notes</h1>
</div>

@if($notes->count() == 0)
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-10 text-center">
        <p class="text-gray-500 text-lg">Vous n'avez pas encore de notes.</p>
    </div>
@else
    @php $moyenne = $notes->avg('note'); @endphp

    <!-- Moyenne générale -->
    <div class="mb-6 rounded-xl p-6 text-center shadow
        @if($moyenne >= 14) bg-green-50 border border-green-200
        @elseif($moyenne >= 10) bg-orange-50 border border-orange-200
        @else bg-red-50 border border-red-200 @endif">
        <p class="text-sm font-semibold text-gray-500 mb-1">Moyenne générale</p>
        <p class="text-5xl font-bold
            @if($moyenne >= 14) text-green-600
            @elseif($moyenne >= 10) text-orange-500
            @else text-red-500 @endif">
            {{ number_format($moyenne, 1) }}<span class="text-2xl">/20</span>
        </p>
        <p class="text-sm mt-2
            @if($moyenne >= 14) text-green-600
            @elseif($moyenne >= 10) text-orange-500
            @else text-red-500 @endif">
            @if($moyenne >= 14) 🎉 Excellent niveau !
            @elseif($moyenne >= 10) 👍 Niveau satisfaisant
            @else 💪 Des efforts à fournir
            @endif
        </p>
    </div>

    <!-- Tableau des notes -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Matière</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Note</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Appréciation</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($notes as $note)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $note->matiere }}</td>
                    <td class="px-6 py-4">
                        <span class="text-2xl font-bold
                            @if($note->note >= 14) text-green-600
                            @elseif($note->note >= 10) text-orange-500
                            @else text-red-500 @endif">
                            {{ number_format($note->note, 1) }}<span class="text-sm text-gray-400">/20</span>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($note->note >= 16)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">⭐ Excellent</span>
                        @elseif($note->note >= 14)
                            <span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-xs font-semibold">👍 Très bien</span>
                        @elseif($note->note >= 12)
                            <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">✓ Bien</span>
                        @elseif($note->note >= 10)
                            <span class="bg-orange-50 text-orange-600 px-3 py-1 rounded-full text-xs font-semibold">→ Satisfaisant</span>
                        @else
                            <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">⚠ À améliorer</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-sm">{{ $note->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<div class="mt-6">
    <a href="{{ route('apprenants.dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">← Retour au tableau de bord</a>
</div>

@endsection
