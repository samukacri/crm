<?php

// Script para atualizar referências de assets Vite para usar caminhos completos
$adminViewsPath = 'packages/Webkul/Admin/src/Resources/views';

// Mapeamento de caminhos antigos para novos caminhos completos
$assetMappings = [
    'images/logo.svg' => 'packages/Webkul/Admin/src/Resources/assets/images/logo.svg',
    'images/dark-logo.svg' => 'packages/Webkul/Admin/src/Resources/assets/images/dark-logo.svg',
    'images/mobile-dark-logo.svg' => 'packages/Webkul/Admin/src/Resources/assets/images/mobile-dark-logo.svg',
    'images/mobile-light-logo.svg' => 'packages/Webkul/Admin/src/Resources/assets/images/mobile-light-logo.svg',
    'images/favicon.ico' => 'packages/Webkul/Admin/src/Resources/assets/images/favicon.ico',
    'images/error.svg' => 'packages/Webkul/Admin/src/Resources/assets/images/error.svg',
    'images/empty-placeholders/' => 'packages/Webkul/Admin/src/Resources/assets/images/empty-placeholders/',
];

// Função para processar arquivos Blade
function updateBladeFiles($directory, $mappings) {
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    
    foreach ($files as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            $updated = false;
            
            foreach ($mappings as $oldPath => $newPath) {
                $pattern = '/vite\(\)->asset\([\'\"]' . preg_quote($oldPath, '/') . '[\'\"]\)/';
                $replacement = 'vite()->asset(\'' . $newPath . '\')';
                
                $newContent = preg_replace($pattern, $replacement, $content);
                if ($newContent !== $content) {
                    $content = $newContent;
                    $updated = true;
                }
            }
            
            if ($updated) {
                file_put_contents($file->getPathname(), $content);
                echo "Updated: " . $file->getPathname() . "\n";
            }
        }
    }
}

// Executar a atualização
updateBladeFiles($adminViewsPath, $assetMappings);

echo "Asset path updates completed!\n";
?>