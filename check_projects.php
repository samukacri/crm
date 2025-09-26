<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== VERIFICANDO PROJETOS ===\n\n";

try {
    $projects = DB::table('projects')->get();
    
    echo "Total de projetos: " . $projects->count() . "\n\n";
    
    if ($projects->count() > 0) {
        foreach ($projects as $project) {
            echo "ID: {$project->id}\n";
            echo "Nome: {$project->name}\n";
            echo "Descrição: {$project->description}\n";
            echo "Status: {$project->status}\n";
            echo "Owner ID: {$project->owner_id}\n";
            echo "Criado em: {$project->created_at}\n";
            echo "----------------------------\n";
        }
    } else {
        echo "Nenhum projeto encontrado.\n";
    }
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}

?>