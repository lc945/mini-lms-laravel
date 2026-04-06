@extends('layouts.app')
@section('title', 'Mes Notes')
@section('content')

<h1 class="text-3xl font-bold mb-8">📊 Mes Notes</h1>

@if($notes->count() == 0)
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
        <p class="text-gray-600 text-lg">Vous n'avez pas encore de notes.</p>
    </div>
@else
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="px-6 py-4 text-left font-semibold">Matière</th>
                    <th class="px-6 py-4 text-left font-semibold">Note</th>
                    <th class="px-6 py-4 text-left font-semibold">Appréciation</th>
                    <th class="px-6 py-4 text-left font-semibold">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($notes as $note)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-800 font-medium">{{ $note->matiere }}</td>
                    <td class="px-6 py-4">
                        <span class="text-2xl font-bold text-blue-600">{{ number_format($note->note, 2) }}<span class="text-sm">/20</span></span>
                    </td>
                    <td class="px-6 py-4">
                        @if($note->note >= 16)
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">⭐ Excellent</span>
                        @elseif($note->note >= 14)
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">👍 Très bien</span>
                        @elseif($note->note >= 12)
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">✓ Bien</span>
                        @elseif($note->note >= 10)
                            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">→ Satisfaisant</span>
                        @else
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">! À améliorer</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $note->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">📈 Moyenne générale</h2>
        <div class="text-5xl font-bold text-blue-600">
            {{ number_format($notes->avg('note'), 2) }}<span class="text-2xl">/20</span>
        </div>
    </div>
@endif

<div class="mt-8">
    <a href="{{ route('apprenants.formations') }}" class="text-blue-600 hover:text-blue-800 font-medium">
        ← Retour aux formations
    </a>
</div>

@endsection
