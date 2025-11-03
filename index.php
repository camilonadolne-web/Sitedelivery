<?php
// ✅ SITE DE COMPRAS PROFISSIONAL COM CONFIGURAÇÕES AUTOMÁTICAS
require_once 'config/site_settings.php';
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SiteSettings::getSiteName(); ?> - Loja Online</title>
    <?php echo SiteSettings::generateMetaTags(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* ✅ ESTILOS BASE */
        .header .logo-container {
            margin-bottom: 15px;
            text-align: center;
            padding: 0px 0px;
        }

        .header .logo-img {
            max-height: 200px !important;
            height: 200px !important;
            width: auto !important;
            border-radius: 8px;
            padding: 0px 0px;
            display: inline-block !important;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #333;
            padding-bottom: 80px;
        }

        .header {
            background: linear-gradient(135deg, #70a60f, #5a850c);
            color: white;
            padding: 30px 20px;
            text-align: center;
            vertical-align: top;
        }

        .header h1 {
            margin-bottom: 10px;
            font-size: 2.8rem;
            font-weight: 700;
        }

        .header p {
            opacity: 0.9;
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* ✅ CARROSSEL */
        .carrossel {
            width: 100%;
            height: 400px;
            overflow: hidden;
            position: relative;
            margin-bottom: 30px;
            touch-action: pan-y;
        }

        .carrossel-slides {
            display: flex;
            transition: transform 0.5s ease;
            height: 100%;
        }

        .carrossel-slide {
            min-width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
        }

        .carrossel-controle {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.5);
            color: white;
            border: none;
            padding: 15px;
            cursor: pointer;
            font-size: 1.5rem;
        }

        .carrossel-prev { left: 10px; }
        .carrossel-next { right: 10px; }

        /* ✅ CATEGORIAS FIXAS - CARROSSEL HORIZONTAL */
        .categorias-container {
            position: sticky;
            top: 0;
            border: 50px;
            z-index: 1000;
            background: #e8f5e8;
            padding: 15px 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .categorias {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            gap: 10px;
            overflow-x: auto !important;
            overflow-y: hidden !important;
            scroll-behavior: smooth;
            padding: 5px 5px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
            white-space: nowrap !important;
        }

        .categorias::-webkit-scrollbar {
            display: none;
        }

        .categoria-btn {
            background: white;
            border: 2px solid #70a60f;
            color: #70a60f;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            white-space: nowrap !important;
            flex-shrink: 0 !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(112, 166, 15, 0.4);
            min-width: max-content;
        }

        .categoria-btn.active,
        .categoria-btn:hover {
            background: #70a60f;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(112, 166, 15, 0.4);
        }

        /* Botões de navegação */
        .categoria-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #70a60f;
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.2rem;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .categoria-nav:hover {
            background: #5a850c;
            transform: translateY(-50%) scale(1.1);
        }

        .categoria-prev {
            left: 5px;
        }

        .categoria-next {
            right: 5px;
        }

        /* ✅ MOBILE - CATEGORIAS FIXAS SEMPRE HORIZONTAIS */
        @media (max-width: 768px) {
            .categorias-container {
                position: sticky;
                top: 0;
                z-index: 1000;
                padding: 5px 0;
                margin-bottom: 15px;
            }
            
            .categorias {
                gap: 6px;
                padding: 3px 0;
                padding: 5px 5px;
                display: flex;
                flex-direction: row;
                flex-wrap: nowrap;
                overflow-x: auto;
                overflow-y: hidden;
            }
            
            .categoria-btn {
                padding: 8px 16px;
                font-size: 0.85rem;
                white-space: nowrap;
                flex-shrink: 0;
                box-shadow: 0 4px 12px rgba(112, 166, 15, 0.4);
                display: inline-flex;
            }
            
            .categoria-nav {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }
            
            .categoria-prev {
                left: 2px;
            }
            
            .categoria-next {
                right: 2px;
            }
        }

        @media (max-width: 480px) {
            .categorias {
                gap: 4px;
            }
            
            .categoria-btn {
                padding: 6px 12px;
                font-size: 0.8rem;
                width: 20px;
                box-shadow: 0 4px 12px rgba(112, 166, 15, 0.4);
            }
            
            .categoria-nav {
                width: 28px;
                height: 28px;
                font-size: 0.9rem;
            }
            
            .categoria-nav:active {
                background: #5a850c;
                transform: translateY(-50%) scale(0.95);
            }
        }

        /* ✅ SKELETON LOADING */
        .skeleton-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .skeleton-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            animation: pulse 1.5s infinite;
        }

        .skeleton-categoria, .skeleton-nome, .skeleton-preco, .skeleton-btn {
            background: #e0e0e0;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .skeleton-categoria { width: 40%; height: 20px; }
        .skeleton-nome { width: 80%; height: 24px; }
        .skeleton-preco { width: 30%; height: 28px; }
        .skeleton-btn { width: 100%; height: 44px; }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        /* ✅ PRODUTOS */
        .produtos-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .produto-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .produto-card:hover {
            transform: translateY(-5px);
        }

        .produto-categoria {
            display: none !important;
        }

        .produto-nome {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #1a3311;
            line-height: 1.4;
        }

        .produto-preco {
            display: none !important;
        }

        .produto-formas {
            font-size: 1rem;
            font-weight: bold;
            color: #2c5e1a;
            background: #f0f7e6;
            padding: 8px 12px;
            border-radius: 6px;
            margin-bottom: 12px;
            border-left: 3px solid #70a60f;
        }

        .produto-estoque {
            font-size: 0.85rem;
            color: #888;
            margin-bottom: 20px;
        }

        .produto-origem {
            font-size: 0.85rem;
            color: #888;
            margin-bottom: 20px;
            font-style: italic;
        }

        .btn-comprar {
            background: #70a60f;
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
            padding: 10px 15px !important;
            font-size: 0.85rem !important;
            min-height: auto;
        }

        .btn-comprar:hover {
            background: #5a850c;
            transform: translateY(-2px);
        }

        /* ✅ TOAST NOTIFICATIONS */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            animation: slideIn 0.3s ease;
            max-width: 400px;
        }

        .toast-content {
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid #28a745;
        }

        .toast-erro .toast-content {
            border-left-color: #dc3545;
        }

        .toast-aviso .toast-content {
            border-left-color: #ffc107;
        }

        .toast-close {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            margin-left: auto;
            color: #666;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* ✅ MODAL DE COMPRA */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 2000;
        }

        .modal-content {
            background: white;
            margin: 50px auto;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #70a60f;
            padding-bottom: 15px;
        }

        .modal-title {
            font-size: 1.5rem;
            color: #1a3311;
            margin: 0;
        }

        .close-modal {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #70a60f;
            outline: none;
        }

        .form-control.erro {
            border-color: #dc3545;
        }

        .erro-validacao {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
        }

        .formas-venda-group {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .forma-venda-option {
            flex: 1;
            text-align: center;
        }

        .forma-venda-btn {
            width: 100%;
            padding: 12px;
            border: 2px solid #70a60f;
            background: white;
            color: #70a60f;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .forma-venda-btn.active {
            background: #70a60f;
            color: white;
        }

        .quantidade-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            text-align: center;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            flex: 1;
        }

        .btn-primary {
            background: #70a60f;
            color: white;
        }

        .btn-primary:hover {
            background: #5a850c;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #545b62;
        }

        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .btn-loading {
            position: relative;
            color: transparent;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin: -8px 0 0 -8px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-right-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ✅ CARRINHO FIXO */
        .carrinho-fixo {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 3px solid #70a60f;
            box-shadow: 0 -4px 15px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: transform 0.3s;
        }

        .carrinho-header {
            background: #70a60f;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .carrinho-titulo {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .carrinho-contador {
            background: white;
            color: #70a60f;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: bold;
        }

        .carrinho-conteudo {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: white;
        }

        .carrinho-aberto .carrinho-conteudo {
            max-height: 400px;
            overflow-y: auto;
        }

        .carrinho-itens {
            padding: 20px;
        }

        .carrinho-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .carrinho-item-info {
            flex: 1;
        }

        .carrinho-item-nome {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .carrinho-item-detalhes {
            font-size: 0.9rem;
            color: #666;
        }

        .carrinho-item-acoes {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-editar, .btn-remover {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .btn-editar {
            background: #17a2b8;
            color: white;
        }

        .btn-remover {
            background: #dc3545;
            color: white;
        }

        .carrinho-total {
            padding: 20px;
            background: #f8f9fa;
            border-top: 1px solid #eee;
            text-align: center;
        }

        .total-valor {
            font-size: 1.3rem;
            font-weight: bold;
            color: #70a60f;
            margin-bottom: 15px;
        }

        .btn-finalizar {
            background: #28a745;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .btn-finalizar:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        /* ✅ MODAL FINALIZAR PEDIDO */
        .modal-cliente {
            max-width: 600px;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-col {
            flex: 1;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .footer {
            background: #1a3311;
            color: white;
            text-align: center;
            padding: 30px;
            margin-top: 50px;
        }

        /* ✅ ESTOQUE BAIXO */
        .estoque-baixo {
            color: #dc3545;
            font-weight: 600;
        }

        /* ✅ ACESSIBILIDADE */
        button:focus, input:focus, select:focus {
            outline: 2px solid #70a60f;
            outline-offset: 2px;
        }

        /* ✅ RESPONSIVIDADE */
        @media (max-width: 1024px) {
            .container {
                padding: 15px;
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
                position: relative;
            }
            
            .produtos-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            
            .carrossel {
                height: 350px;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 20px 15px !important;
            }
            
            .header .logo-img {
                max-height: 60px !important;
                height: 60px !important;
            }
            
            .header h1 {
                font-size: 1.8rem !important;
                margin-bottom: 8px;
            }
            
            .header p {
                font-size: 1rem !important;
            }
            
            .carrossel {
                height: 250px;
                margin-bottom: 20px;
            }
            
            .carrossel-controle {
                padding: 10px;
                font-size: 1.2rem;
            }
            
            .container {
                padding-top: 10px;
            }
            
            .categorias {
                flex-direction: column;
                align-items: center;
                gap: 8px;
                margin-bottom: 0px;
            }
            
            .categoria-btn {
                min-width: max-content;
                max-width: 280px;
                padding: 12px 20px;
                font-size: 0.9rem;
            }
            
            .produtos-grid {
                grid-template-columns: 1fr;
                gap: 15px;
                margin-bottom: 30px;
            }
            
            .produto-card {
                padding: 20px;
            }
            
            .produto-nome {
                font-size: 1.2rem;
            }
            
            .produto-preco {
                font-size: 1.4rem;
            }
            
            .btn-comprar {
                padding: 12px 20px;
                font-size: 0.9rem;
            }
            
            .carrinho-header {
                padding: 12px 15px;
            }
            
            .carrinho-titulo {
                font-size: 1.1rem;
            }
            
            .carrinho-contador {
                padding: 3px 10px;
                font-size: 0.9rem;
            }
            
            .carrinho-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .carrinho-item-acoes {
                width: 100%;
                justify-content: flex-end;
            }
            
            .btn-finalizar {
                padding: 12px 20px;
                font-size: 1rem;
            }
            
            .modal-content {
                margin: 20px auto;
                padding: 20px;
                width: 95%;
            }
            
            .modal-header {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
            
            .modal-title {
                font-size: 1.3rem;
            }
            
            .form-row {
                flex-direction: column;
                gap: 10px;
            }
            
            .formas-venda-group {
                flex-direction: column;
                gap: 10px;
            }
            
            .modal-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
            
            .footer {
                padding: 20px;
                margin-top: 30px;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 15px 10px !important;
            }
            
            .header .logo-img {
                max-height: 50px !important;
                height: 50px !important;
            }
            
            .header h1 {
                font-size: 1.6rem !important;
            }
            
            .header p {
                font-size: 0.9rem !important;
            }
            
            .carrossel {
                height: 200px;
            }
            
            .produto-card {
                padding: 15px;
            }
            
            .produto-nome {
                font-size: 1.1rem;
            }
            
            .produto-preco {
                font-size: 1.3rem;
            }
            
            .categoria-btn {
                max-width: 50%;
                font-size: 0.85rem;
                padding: 10px 15px;
                border: 5px solid transparent;
            }
            
            .carrinho-itens {
                padding: 15px;
            }
            
            .modal-content {
                padding: 15px;
                margin: 10px auto;
            }
            
            .footer {
                padding: 15px 10px;
            }
        }

        /* ✅ ESTILO PARA BOTÕES DE ENTREGA */
        .formas-entrega-group {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .forma-entrega-option {
            flex: 1;
            text-align: center;
        }

        .forma-entrega-btn {
            width: 100%;
            padding: 15px;
            border: 2px solid #70a60f;
            background: white;
            color: #70a60f;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .forma-entrega-btn.active {
            background: #70a60f;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(112, 166, 15, 0.3);
        }

        .forma-entrega-btn:hover:not(.active) {
            background: #f8f9fa;
            transform: translateY(-1px);
        }

        /* ✅ ESTILO PARA MENSAGEM DE DELIVERY */
        .aviso-delivery {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ✅ RESPONSIVIDADE */
        @media (max-width: 768px) {
            .formas-entrega-group {
                flex-direction: column;
                gap: 10px;
            }
            
            .forma-entrega-btn {
                padding: 12px;
                font-size: 0.9rem;
            }
            
            .aviso-delivery div {
                padding: 12px !important;
            }
            
            .aviso-delivery div div {
                font-size: 0.85rem !important;
            }
        }

        @media (max-width: 480px) {
            .forma-entrega-btn {
                padding: 10px;
                font-size: 0.85rem;
            }
            
            .aviso-delivery div {
                padding: 10px !important;
            }
            
            .aviso-delivery div div {
                font-size: 0.8rem !important;
            }
        }

        /* ✅ ESTILO PARA MENSAGEM INFORMATIVA */
        .aviso-unidade {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ✅ RESPONSIVIDADE PARA A MENSAGEM */
        @media (max-width: 768px) {
            .aviso-unidade div {
                padding: 8px 12px !important;
                font-size: 0.85rem !important;
            }
            
            .aviso-unidade span {
                font-size: 0.8rem !important;
            }
        }

        @media (max-width: 480px) {
            .aviso-unidade div {
                padding: 6px 10px !important;
                font-size: 0.8rem !important;
            }
            
            .aviso-unidade span {
                font-size: 0.75rem !important;
            }
        }

        /* ✅ ESTILO PARA INFORMAÇÕES IMPORTANTES */
        .informacoes-importantes {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 25px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .info-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            background: #e8f5e8;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }

        .info-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .info-icon {
            font-size: 1.5rem;
            background: #70a60f;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-title {
            color: #1a3311;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
        }

        .info-content {
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-days {
            color: #495057;
            font-weight: 600;
            font-size: 1rem;
        }

        .info-hours {
            color: #70a60f;
            font-weight: 700;
            font-size: 1rem;
        }

        .info-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #70a60f, transparent);
            margin: 20px 0;
        }

        .info-pagamento {
            margin-top: 20px;
        }

        .info-text {
            color: #495057;
            font-size: 1rem;
            line-height: 1.6;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #70a60f;
        }

        /* ✅ RESPONSIVIDADE */
        @media (max-width: 768px) {
            .informacoes-importantes {
                padding: 20px 0;
            }
            
            .info-card {
                padding: 20px;
                border-radius: 12px;
            }
            
            .info-header {
                gap: 10px;
                margin-bottom: 12px;
            }
            
            .info-icon {
                font-size: 1.3rem;
                width: 35px;
                height: 35px;
            }
            
            .info-title {
                font-size: 1.1rem;
            }
            
            .info-days,
            .info-hours {
                font-size: 0.9rem;
            }
            
            .info-text {
                font-size: 0.9rem;
                padding: 12px;
            }
            
            .info-divider {
                margin: 15px 0;
            }
        }

        @media (max-width: 480px) {
            .informacoes-importantes {
                padding: 15px 0;
            }
            
            .info-card {
                padding: 15px;
                border-radius: 10px;
            }
            
            .info-header {
                flex-direction: column;
                text-align: center;
                gap: 8px;
            }
            
            .info-item {
                flex-direction: column;
                text-align: center;
                gap: 5px;
                padding: 10px 0;
            }
            
            .info-days,
            .info-hours {
                font-size: 0.85rem;
            }
            
            .info-text {
                font-size: 0.85rem;
                padding: 10px;
                text-align: center;
            }
            
            .info-divider {
                margin: 12px 0;
            }
        }

        /* ✅ ESTILOS PARA BOTÕES DO CARRINHO */
        .carrinho-item-acoes {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-editar, .btn-remover {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s;
            font-weight: 600;
            min-width: 80px;
        }

        .btn-editar {
            background: #17a2b8;
            color: white;
        }

        .btn-editar:hover {
            background: #138496;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(23, 162, 184, 0.3);
        }

        .btn-remover {
            background: #dc3545;
            color: white;
        }

        .btn-remover:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        /* ✅ RESPONSIVIDADE */
        @media (max-width: 768px) {
            .carrinho-item-acoes {
                width: 100%;
                justify-content: space-between;
            }
            
            .btn-editar, .btn-remover {
                flex: 1;
                padding: 10px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .btn-editar, .btn-remover {
                padding: 8px;
                font-size: 0.8rem;
                min-width: 70px;
            }
        }

        /* ✅ ESTILOS PARA VARIAÇÕES */
        .variacoes-group {
            margin-bottom: 20px;
        }

        .variacao-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
        }

        .variacoes-opcoes {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
        }

        .variacao-opcao {
            flex: 1;
            min-width: 80px;
            text-align: center;
        }

        .variacao-btn {
            width: 100%;
            padding: 10px 8px;
            border: 2px solid #ddd;
            background: white;
            color: #666;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            font-size: 0.85rem;
        }

        .variacao-btn:hover {
            border-color: #70a60f;
            color: #70a60f;
        }

        .variacao-btn.selected {
            background: #70a60f;
            color: white;
            border-color: #70a60f;
        }

        .variacao-btn:disabled {
            background: #f8f9fa;
            color: #ccc;
            cursor: not-allowed;
            border-color: #eee;
        }

        .preco-variacao {
            font-size: 0.8rem;
            color: #28a745;
            margin-top: 4px;
        }

        .estoque-variacao {
            font-size: 0.75rem;
            color: #666;
            margin-top: 2px;
        }

        /* ✅ ESTILOS PARA VARIAÇÕES - COMPLEMENTO */
        .variacao-tipo-group {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            margin-bottom: 15px;
        }

        .variacao-btn.selected {
            background: #70a60f !important;
            color: white !important;
            border-color: #70a60f !important;
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(112, 166, 15, 0.3);
        }

        .variacao-btn:disabled {
            background: #f8f9fa !important;
            color: #ccc !important;
            cursor: not-allowed !important;
            border-color: #eee !important;
            transform: none !important;
        }

        .variacao-btn:disabled:hover {
            transform: none !important;
        }

        .preco-variacao {
            font-size: 0.75rem;
            color: #28a745;
            margin-top: 4px;
            font-weight: 600;
        }

        .estoque-variacao {
            font-size: 0.7rem;
            color: #666;
            margin-top: 2px;
        }

        /* ✅ RESPONSIVIDADE PARA VARIAÇÕES */
        @media (max-width: 768px) {
            .variacoes-opcoes {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .variacao-tipo-group {
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            .variacoes-opcoes {
                grid-template-columns: 1fr;
            }
            
            .variacao-btn {
                padding: 12px 8px;
                font-size: 0.8rem;
            }
        }

        /* ✅ ESTILOS PARA VARIAÇÕES SIMPLIFICADAS */
        .variacao-btn-simples {
            padding: 8px 16px;
            border: 2px solid #e0e0e0;
            background: white;
            color: #666;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .variacao-btn-simples:hover {
            border-color: #70a60f;
            color: #70a60f;
        }

        .variacao-btn-simples.selecionado {
            background: #70a60f;
            color: white;
            border-color: #70a60f;
        }

        /* ✅ ESTILOS PARA VARIAÇÕES COM SELEÇÃO ÚNICA */
        .variacao-btn-simples {
            padding: 10px 18px;
            border: 2px solid #e0e0e0;
            background: white;
            color: #666;
            border-radius: 25px;
            cursor: pointer;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            white-space: nowrap;
            font-weight: 500;
        }

        .variacao-btn-simples:hover {
            border-color: #70a60f;
            color: #70a60f;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(112, 166, 15, 0.2);
        }

        .variacao-btn-simples.selecionado {
            background: #70a60f;
            color: white;
            border-color: #70a60f;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(112, 166, 15, 0.3);
        }
/* ✅ ESTILO PARA AVISO DE FORMA DE VENDA */
.aviso-forma-venda {
    animation: fadeIn 0.3s ease;
    margin-bottom: 15px;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
/* ✅ ANIMAÇÃO PULSE PARA DESTAQUE */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.pulse-animation {
    animation: pulse 0.5s ease-in-out 3;
}
/* ✅ ESTILOS PARA VARIAÇÕES SIMPLIFICADAS */
.variacao-btn-simples {
    padding: 8px 16px;
    border: 2px solid #e0e0e0;
    background: white;
    color: #666;
    border-radius: 20px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.variacao-btn-simples:hover {
    border-color: #70a60f;
    color: #70a60f;
}

.variacao-btn-simples.selecionado {
    background: #70a60f;
    color: white;
    border-color: #70a60f;
}
/* ✅ ESTILOS PARA IMAGENS DOS PRODUTOS - CORRIGIDO */
/* ✅ ESTILOS PARA IMAGENS DOS PRODUTOS - LADO A LADO EM TODOS OS DISPOSITIVOS */
.produto-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s;
    display: grid;
    grid-template-columns: 1fr auto; /* ✅ SEMPRE LADO A LADO */
    gap: 20px;
    align-items: start;
    min-height: 160px;
}

.produto-card:hover {
    transform: translateY(-5px);
}

.produto-info {
    flex: 1;
    min-width: 0;
    text-align: left; /* ✅ SEMPRE ALINHADO À ESQUERDA */
}

.produto-imagem-container {
    width: 120px;
    height: 120px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    overflow: hidden;
    border: 3px solid #e8f5e8;
    background: #f8f9fa;
    position: relative;
}

/* ✅ IMAGEM QUE CABE NO QUADRADO SEM CORTAR */
.produto-imagem {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    transition: transform 0.3s ease;
    background: white;
}

.produto-imagem:hover {
    transform: scale(1.05);
}

.produto-imagem-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #e8f5e8, #d4edda);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #70a60f;
    font-size: 2.5rem;
}

/* ✅ CONTROLE DE TAMANHO DA IMAGEM */
.imagem-pequena .produto-imagem-container {
    width: 100px;
    height: 100px;
}

.imagem-media .produto-imagem-container {
    width: 120px;
    height: 120px;
}

.imagem-grande .produto-imagem-container {
    width: 140px;
    height: 140px;
}

/* ✅ OPÇÃO: IMAGEM QUE PREENCHE O QUADRADO (COM CORTE) */
.imagem-preenchida .produto-imagem {
    object-fit: cover;
}

/* ✅ OPÇÃO: IMAGEM QUE CABE INTEIRA (SEM CORTE) */
.imagem-inteira .produto-imagem {
    object-fit: contain;
}

/* ✅ RESPONSIVIDADE - AJUSTES PARA TELAS PEQUENAS */
@media (max-width: 1024px) {
    .produto-card {
        padding: 18px;
        gap: 18px;
        min-height: 150px;
    }
    
    .produto-imagem-container {
        width: 110px;
        height: 110px;
    }
    
    .imagem-pequena .produto-imagem-container {
        width: 90px;
        height: 90px;
    }
    
    .imagem-grande .produto-imagem-container {
        width: 120px;
        height: 120px;
    }
    
    .produto-imagem-placeholder {
        font-size: 2.2rem;
    }
}

@media (max-width: 768px) {
    .produto-card {
        grid-template-columns: 1fr auto; /* ✅ MANTÉM LADO A LADO NO CELULAR */
        gap: 15px;
        padding: 15px;
        min-height: 140px;
        align-items: center; /* ✅ CENTRALIZA VERTICALMENTE */
    }
    
    .produto-info {
        order: 0; /* ✅ INFORMAÇÕES À ESQUERDA */
        text-align: left;
    }
    
    .produto-imagem-container {
        width: 100px; /* ✅ IMAGEM UM POUCO MENOR NO CELULAR */
        height: 100px;
        order: 1; /* ✅ IMAGEM À DIREITA */
        margin: 0; /* ✅ REMOVE MARGEM AUTOMÁTICA */
    }
    
    .imagem-pequena .produto-imagem-container {
        width: 80px;
        height: 80px;
    }
    
    .imagem-grande .produto-imagem-container {
        width: 110px;
        height: 110px;
    }
    
    .produto-imagem-placeholder {
        font-size: 2rem;
    }
    
    /* ✅ AJUSTES DE TEXTO PARA CELULAR */
    .produto-nome {
        font-size: 1.1rem;
        line-height: 1.3;
        margin-bottom: 10px;
    }
    
    .produto-formas {
        font-size: 0.9rem;
        padding: 6px 10px;
        margin-bottom: 10px;
    }
    
    .produto-estoque,
    .produto-origem {
        font-size: 0.8rem;
        margin-bottom: 12px;
    }
    
    .btn-comprar {
        padding: 8px 12px !important;
        font-size: 0.8rem !important;
    }
}

@media (max-width: 480px) {
    .produto-card {
        padding: 12px;
        gap: 12px;
        min-height: 130px;
    }
    
    .produto-imagem-container {
        width: 90px;
        height: 90px;
    }
    
    .imagem-pequena .produto-imagem-container {
        width: 70px;
        height: 70px;
    }
    
    .imagem-grande .produto-imagem-container {
        width: 100px;
        height: 100px;
    }
    
    .produto-imagem-placeholder {
        font-size: 1.8rem;
    }
    
    /* ✅ AJUSTES ADICIONAIS PARA CELULARES PEQUENOS */
    .produto-nome {
        font-size: 1rem;
        margin-bottom: 8px;
    }
    
    .produto-formas {
        font-size: 0.85rem;
        padding: 5px 8px;
        margin-bottom: 8px;
    }
    
    .produto-categoria {
        font-size: 0.75rem;
        padding: 4px 8px;
        margin-bottom: 8px;
    }
    
    .btn-comprar {
        padding: 7px 10px !important;
        font-size: 0.75rem !important;
    }
}

/* ✅ CELULARES MUITO PEQUENOS (MENOS DE 360px) */
@media (max-width: 360px) {
    .produto-card {
        grid-template-columns: 1fr 80px; /* ✅ GARANTE ESPAÇO MÍNIMO */
        gap: 10px;
        padding: 10px;
    }
    
    .produto-imagem-container {
        width: 80px;
        height: 80px;
    }
    
    .imagem-pequena .produto-imagem-container {
        width: 60px;
        height: 60px;
    }
    
    .imagem-grande .produto-imagem-container {
        width: 90px;
        height: 90px;
    }
    
    .produto-imagem-placeholder {
        font-size: 1.6rem;
    }
}

/* ✅ GARANTIR QUE O GRID SEJA SEMPRE DE UMA COLUNA EM CELULAR */
@media (max-width: 768px) {
    .produtos-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
}

/* ✅ SKELETON LOADING ATUALIZADO */
.skeleton-imagem {
    width: 120px;
    height: 120px;
    background: #e0e0e0;
    border-radius: 12px;
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .skeleton-imagem {
        width: 140px;
        height: 140px;
        margin: 0 auto 15px;
    }
}
    </style>
</head>
<body>
    <!-- Cabeçalho -->
<div class="header">
    <div class="logo-container">
        <img src="images/logo.png" alt="<?php echo SiteSettings::getSiteName(); ?>" class="logo-img">
    </div>
    <p><?php echo SiteSettings::getSlogan(); ?></p>
</div>

    <!-- Carrossel -->
    <div class="carrossel" id="carrossel">
        <div class="carrossel-slides" id="carrosselSlides">
            <!-- Imagens serão carregadas via JavaScript -->
        </div>
        <button class="carrossel-controle carrossel-prev" onclick="moverCarrossel(-1)">❮</button>
        <button class="carrossel-controle carrossel-next" onclick="moverCarrossel(1)">❯</button>
    </div>

<!-- ✅ INFORMAÇÕES IMPORTANTES -->
<div class="informacoes-importantes">
    <div class="container">
        <div class="info-card">
            <div class="info-header">
                <span class="info-icon">⏰</span>
                <h3 class="info-title">Horário de Funcionamento - Loja Física</h3>
            </div>
            <div class="info-content">
                <?php
                $horario = SiteSettings::getHorarioFuncionamento();
                // Processar o horário para manter o formato original
                $horarios = explode('|', $horario);
                foreach ($horarios as $horario_item) {
                    $partes = explode(':', $horario_item, 2);
                    if (count($partes) === 2) {
                        echo '<div class="info-item">';
                        echo '<span class="info-days">' . trim($partes[0]) . ':</span>';
                        echo '<span class="info-hours">' . trim($partes[1]) . '</span>';
                        echo '</div>';
                    } else {
                        echo '<div class="info-item">';
                        echo '<span class="info-days">' . trim($horario_item) . '</span>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
            
            <div class="info-divider"></div>
            
            <div class="info-pagamento">
                <div class="info-header">
                    <span class="info-icon">💰</span>
                    <h3 class="info-title">(PAGAMENTO DO PEDIDO)</h3>
                </div>
                <div class="info-text">
                    O valor do seu pedido será gerado após a seleção e pesagem dos itens no Kg.<br>
                    Enviaremos a notinha pelo WhatsApp com valor.
                </div>

                <!-- ✅ INFORMAÇÕES DE ENTREGA DINÂMICAS -->
                <div style="margin-top: 20px;">
                    <?php 
                    $taxaEntrega = SiteSettings::getTaxaEntrega();
                    $infoTaxaEntrega = SiteSettings::getInfoTaxaEntrega();
                    $valorFreteGratis = SiteSettings::getValorFreteGratis();
                    $tempoEntrega = SiteSettings::getTempoEntrega();
                    ?>
                    
                    <?php if ($taxaEntrega > 0): ?>
                    <div style="background: #f8f9fa; padding: 12px; border-radius: 8px; border-left: 4px solid #70a60f; margin-bottom: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600; color: #1a3311;">🚚 Taxa de Entrega:</span>
                            <span style="font-weight: 700; color: #70a60f;">
                                R$ <?php echo number_format($taxaEntrega, 2, ',', '.'); ?>
                            </span>
                        </div>
                        <div style="font-size: 0.9rem; color: #666; margin-top: 5px;">
                            ⏱️ <?php echo htmlspecialchars($tempoEntrega); ?>
                        </div>
                        
                        <!-- ✅ INFO TAXA ENTREGA -->
                        <?php if (!empty(trim($infoTaxaEntrega))): ?>
                        <div style="margin-top: 8px; padding: 8px; background: #e8f5e8; border-radius: 5px; border-left: 3px solid #28a745;">
                            <span style="font-size: 0.85rem; color: #1a3311;">
                                💡 <?php echo htmlspecialchars($infoTaxaEntrega); ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($valorFreteGratis > 0): ?>
                    <div style="background: #e8f5e8; padding: 12px; border-radius: 8px; border-left: 4px solid #28a745;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600; color: #1a3311;">🎉 Frete Grátis:</span>
                            <span style="font-weight: 700; color: #28a745;">
                                Acima de R$ <?php echo number_format($valorFreteGratis, 2, ',', '.'); ?>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Conteúdo Principal -->
    <div class="container">
        <!-- ✅ CATEGORIAS FIXAS - CARROSSEL HORIZONTAL -->
        <div class="categorias-container">
            <div class="categorias-wrapper">
                <div class="categorias" id="categoriasCarrossel">
                    <button class="categoria-btn active" onclick="filtrarCategoria('todos')">Todos</button>
                    <!-- As categorias serão carregadas dinamicamente via JavaScript -->
                </div>
            </div>
        </div>

        <!-- Grid de Produtos -->
        <div id="produtos-container" class="loading">
            <div class="skeleton-grid">
                <div class="skeleton-card">
                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 20px; align-items: start;">
                    <div class="skeleton-categoria"></div>
                    <div class="skeleton-nome"></div>
                    <div class="skeleton-preco"></div>
                    <div class="skeleton-btn"></div>
                </div>
                <div class="skeleton-imagem"></div>
        </div>
    </div>
    <div class="skeleton-card">
        <div style="display: grid; grid-template-columns: 1fr auto; gap: 20px; align-items: start;">
            <div>
                    <div class="skeleton-categoria"></div>
                    <div class="skeleton-nome"></div>
                    <div class="skeleton-preco"></div>
                    <div class="skeleton-formas"></div>
                    <div class="skeleton-btn"></div>
                </div>
                <div class="skeleton-imagem"></div>
        </div>
    </div>
    <div class="skeleton-card">
        <div style="display: grid; grid-template-columns: 1fr auto; gap: 20px; align-items: start;">
            <div>
                    <div class="skeleton-categoria"></div>
                    <div class="skeleton-nome"></div>
                    <div class="skeleton-preco"></div>
                    <div class="skeleton-formas"></div>
                    <div class="skeleton-btn"></div>
                </div>
                <div class="skeleton-imagem"></div>
            </div>
        </div>
    </div>

    <!-- Modal de Compra -->
    <div id="modalCompra" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalProdutoNome">Adicionar ao Carrinho</h3>
                <button class="close-modal" onclick="fecharModalCompra()">✕</button>
            </div>
            <div id="modalCompraConteudo">
                <!-- Conteúdo será preenchido via JavaScript -->
            </div>
        </div>
    </div>

    <!-- Modal Finalizar Pedido -->
    <div id="modalFinalizar" class="modal">
        <div class="modal-content modal-cliente">
            <div class="modal-header">
                <h3 class="modal-title">Finalizar Pedido</h3>
                <button class="close-modal" onclick="fecharModalFinalizar()">✕</button>
            </div>
            <form id="formCliente" onsubmit="enviarPedido(event)">
                <div class="form-row">
                    <div class="form-col">
                        <label class="form-label">Nome Completo *</label>
                        <input type="text" class="form-control" name="nome" required>
                    </div>
                    <div class="form-col">
                        <label class="form-label">E-mail *</label>
                        <input type="email" class="form-control" name="email" required placeholder="seu@email.com">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <label class="form-label">Telefone/WhatsApp *</label>
                        <input type="tel" class="form-control" name="telefone" placeholder="(86) 99999-9999" required>
                    </div>
                    <div class="form-col">
                        <label class="form-label">CEP *</label>
                        <input type="text" class="form-control" name="cep" placeholder="00000-000" required 
                               maxlength="9" oninput="formatarCEP(this)">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <label class="form-label">Endereço *</label>
                        <input type="text" class="form-control" name="endereco" required>
                    </div>
                    <div class="form-col">
                        <label class="form-label">Número *</label>
                        <input type="text" class="form-control" name="numero" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Complemento</label>
                    <input type="text" class="form-control" name="complemento" placeholder="Apartamento, bloco, etc.">
                </div>
<div class="form-group">
    <label class="form-label">Forma de Pagamento *</label>
    <select class="form-control" name="forma_pagamento" required id="selectFormaPagamento">
        <option value="">Selecione...</option>
        <!-- As opções serão preenchidas dinamicamente via JavaScript -->
    </select>
</div>
                <div class="form-group">
                    <label class="form-label">Observações do Pedido</label>
                    <textarea class="form-control" name="observacoes" rows="3" 
                              placeholder="Alguma observação especial? Ponto de referência? Horário preferencial para entrega?"></textarea>
                </div>
                
                <!-- ✅ NOVO: BOTÕES DELIVERY/RETIRADA -->
                <div class="form-group">
                    <label class="form-label">Tipo de Entrega *</label>
                    <div class="formas-entrega-group">
                        <div class="forma-entrega-option">
                            <button type="button" class="forma-entrega-btn" onclick="selecionarTipoEntrega('delivery')" id="btnDelivery">
                                🚚 Delivery
                            </button>
                        </div>
                        <div class="forma-entrega-option">
                            <button type="button" class="forma-entrega-btn" onclick="selecionarTipoEntrega('retirada')" id="btnRetirada">
                                🏪 Retirada
                            </button>
                        </div>
                    </div>
                    
                    <!-- ✅ MENSAGEM INFORMATIVA PARA DELIVERY -->
                    <div class="aviso-delivery" id="avisoDelivery" style="display: none;">
                        <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 15px; margin-top: 15px;">
                            <div style="color: #856404; font-size: 0.9rem; line-height: 1.4;">
                                <div style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 8px;">
                                    <span style="font-size: 1.1rem;">💡</span>
                                    <div>
                                        <strong>VALOR DA TAXA DE ENTREGA É APENAS UMA SIMULAÇÃO, CONSULTE O VALOR PARA SUA REGIÃO!</strong>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: flex-start; gap: 10px;">
                                    <span style="font-size: 1.1rem;">📦</span>
                                    <div>
                                        <strong>Após seleção e pesagem dos produtos, enviamos o valor da compra.</strong>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: flex-start; gap: 10px; margin-top: 8px;">
                                    <span style="font-size: 1.1rem;">💰</span>
                                    <div>
                                        <strong>OBS: Seu pedido é enviado após o envio do comprovante de pagamento.</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumo do Pedido -->
                <div class="resumo-pedido" style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h4 style="margin-bottom: 10px;">📦 Resumo do Pedido</h4>
                    <div id="resumoItens"></div>
                    <div style="border-top: 1px solid #ddd; padding-top: 10px; margin-top: 10px;">
                        <strong>Total: R$ <span id="resumoTotal">0,00</span></strong>
                    </div>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="fecharModalFinalizar()">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnEnviarPedido">
                        ✅ Enviar Pedido
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Carrinho Fixo -->
    <div class="carrinho-fixo" id="carrinhoFixo">
        <div class="carrinho-header" onclick="toggleCarrinho()">
            <span class="carrinho-titulo">🛒 Meu Carrinho</span>
            <span class="carrinho-contador" id="carrinhoContador">0</span>
        </div>
        <div class="carrinho-conteudo">
            <div class="carrinho-itens" id="carrinhoItens">
                <div style="text-align: center; padding: 20px; color: #666;">Seu carrinho está vazio</div>
            </div>
            <div class="carrinho-total">
                <div class="total-valor">Total: R$ <span id="carrinhoTotal">0,00</span></div>
                <button class="btn-finalizar" onclick="abrirModalFinalizar()" id="btnFinalizar" disabled>
                    📦 Enviar Pedido
                </button>
            </div>
        </div>
    </div>
   
<!-- Rodapé -->
<div class="footer">
    <p>🌱 <?php echo SiteSettings::getSiteName(); ?> - Qualidade que você vê, sabor que você sente</p>
    <p>
        📞 <?php echo SiteSettings::getTelefone(); ?> | 
        ✉️ <?php echo SiteSettings::getEmail(); ?>
        
        <?php if (SiteSettings::getWhatsapp()): ?>
        | 
        <a href="https://wa.me/55<?php echo preg_replace('/[^0-9]/', '', SiteSettings::getWhatsapp()); ?>" 
           target="_blank" 
           style="color: white; text-decoration: underline;">
            💬 Fale no WhatsApp
        </a>
        <?php endif; ?>
        
        <?php 
        $instagram = SiteSettings::getInstagram();
        if (!empty(trim($instagram))): 
        ?>
        | 
        <a href="<?php echo htmlspecialchars($instagram); ?>" 
           target="_blank" 
           style="color: white; text-decoration: underline;">
            📷 Siga no Instagram
        </a>
        <?php endif; ?>
    </p>
    
    <?php if (SiteSettings::getEndereco()): ?>
    <p style="margin-top: 8px; font-size: 0.9rem; opacity: 0.9;">
        📍 <?php echo SiteSettings::getEndereco(); ?>
    </p>
    <?php endif; ?>
</div>
<!-- Botão WhatsApp Fixo -->
<div class="whatsapp-fixed">
    <a href="https://wa.me/55<?php echo preg_replace('/[^0-9]/', '', SiteSettings::getWhatsapp()); ?>?text=Olá! Gostaria de fazer um pedido." 
       class="whatsapp-btn" 
       target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>

<style>
.whatsapp-fixed {
    position: fixed;
    bottom: 80px;
    right: 20px;
    z-index: 1000;
}

.whatsapp-btn {
    width: 60px;
    height: 60px;
    background: #25D366;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
    transition: all 0.3s ease;
    animation: pulse 2s infinite;
}

.whatsapp-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

@media (max-width: 768px) {
    .whatsapp-btn {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }
}
</style>

<script>
    // ========== CONFIGURAÇÕES GLOBAIS ==========
    const CONFIG = {
        TIMEOUT_API: 8000,
        DEBOUNCE_DELAY: 500,
            PRODUTOS_LOCAIS: [
                {
                    id: 1,
                    nome: "Maçã Fuji Orgânica",
                    categoria: "frutas",
                    preco_base: 8.90,
                    precos: { kg: 8.90, unidade: 1.50 },
                    formas_venda: { kg: true, unidade: true },
                    origem: "Produtor Local - Serra Gaúcha",
                    ativo: true,
                    permite_observacoes: true
                },
                {
                    id: 2,
                    nome: "Alface Crespa",
                    categoria: "hortalicas", 
                    preco_base: 4.50,
                    precos: { kg: 4.50, unidade: 2.00 },
                    formas_venda: { kg: true, unidade: true },
                    origem: "Horta Própria - Orgânico",
                    ativo: true,
                    permite_observacoes: false
                },
                {
                    id: 3,
                    nome: "Cebolinha Verde",
                    categoria: "temperos",
                    preco_base: 2.50,
                    precos: { kg: 25.00, unidade: 2.50 },
                    formas_venda: { kg: true, unidade: true },
                    origem: "Horta Familiar - Produto Fresco",
                    ativo: true,
                    permite_observacoes: true
                }
            ]
        };

        // ========== VARIÁVEIS GLOBAIS ==========
        let produtos = [];
        let categorias = [];
        let carrinho = JSON.parse(localStorage.getItem('carrinho_ouro_verde')) || [];
        let categoriaAtiva = 'todos';
        let produtoSelecionado = null;
        let formaVendaSelecionada = null;
        let variacaoSelecionada = null;
        let slideAtual = 0;
        let timeoutCarrossel;
        let tipoEntregaSelecionado = null;
        let variacoesSelecionadas = {};

        // ========== UTILITÁRIOS GERAIS ==========
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function mostrarToast(mensagem, tipo = 'sucesso') {
            document.querySelectorAll('.toast').forEach(toast => {
                if (toast.parentElement) toast.remove();
            });

            const toast = document.createElement('div');
            toast.className = `toast toast-${tipo}`;
            toast.innerHTML = `
                <div class="toast-content">
                    <span class="toast-icon">${tipo === 'sucesso' ? '✅' : tipo === 'erro' ? '❌' : '⚠️'}</span>
                    <span class="toast-message">${mensagem}</span>
                    <button class="toast-close" onclick="this.parentElement.parentElement.remove()">×</button>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                if (toast.parentElement) toast.remove();
            }, 4000);
        }

        function prevenirDuploClique(botao, tempo = 3000) {
            botao.disabled = true;
            botao.classList.add('btn-loading');
            setTimeout(() => {
                botao.disabled = false;
                botao.classList.remove('btn-loading');
            }, tempo);
        }

        function validarEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        function validarTelefone(telefone) {
            const regex = /^\(?\d{2}\)?[\s-]?\d{4,5}-?\d{4}$/;
            return regex.test(telefone.replace(/\s/g, ''));
        }

        function validarCEP(cep) {
            const cepLimpo = cep.replace(/\D/g, '');
            return cepLimpo.length === 8;
        }

        function formatarCEP(input) {
            let cep = input.value.replace(/\D/g, '');
            if (cep.length > 5) {
                cep = cep.substring(0,5) + '-' + cep.substring(5,8);
            }
            input.value = cep;
            
            if (cep.length === 9) {
                buscarEnderecoDebounced(cep);
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // ========== GERENCIAMENTO DE DADOS ==========
        function salvarDadosCliente(dadosCliente) {
            localStorage.setItem('cliente_ouro_verde', JSON.stringify({
                nome: dadosCliente.nome,
                email: dadosCliente.email,
                telefone: dadosCliente.telefone,
                cep: dadosCliente.cep,
                endereco: dadosCliente.endereco,
                numero: dadosCliente.numero,
                complemento: dadosCliente.complemento,
                salvo_em: new Date().toISOString()
            }));
        }

        function carregarDadosCliente() {
            const dadosSalvos = localStorage.getItem('cliente_ouro_verde');
            return dadosSalvos ? JSON.parse(dadosSalvos) : null;
        }

        function preencherFormularioCliente() {
            const dadosCliente = carregarDadosCliente();
            if (dadosCliente) {
                const form = document.getElementById('formCliente');
                form.querySelector('input[name="nome"]').value = dadosCliente.nome || '';
                form.querySelector('input[name="email"]').value = dadosCliente.email || '';
                form.querySelector('input[name="telefone"]').value = dadosCliente.telefone || '';
                form.querySelector('input[name="cep"]').value = dadosCliente.cep || '';
                form.querySelector('input[name="endereco"]').value = dadosCliente.endereco || '';
                form.querySelector('input[name="numero"]').value = dadosCliente.numero || '';
                form.querySelector('input[name="complemento"]').value = dadosCliente.complemento || '';
            }
        }

        function salvarCarrinho() {
            localStorage.setItem('carrinho_ouro_verde', JSON.stringify(carrinho));
        }

        // ========== CATEGORIAS ==========
        async function carregarCategorias() {
            const categoriasMap = {};
            
            produtos.forEach(produto => {
                if (produto.categoria_id && produto.categoria_nome) {
                    if (!categoriasMap[produto.categoria_id]) {
                        categoriasMap[produto.categoria_id] = {
                            id: produto.categoria_id,
                            nome: produto.categoria_nome,
                            cor: produto.categoria_cor || '#70a60f',
                            total_produtos: 0
                        };
                    }
                    categoriasMap[produto.categoria_id].total_produtos++;
                }
            });
            
            categorias = Object.values(categoriasMap);
            console.log(`🏷️ ${categorias.length} categorias extraídas dos produtos`);
            renderizarCategorias();
        }

        function renderizarCategorias() {
            const containerCategorias = document.querySelector('.categorias');
            if (!containerCategorias) {
                console.error('❌ Container de categorias não encontrado');
                return;
            }
            
            const btnFolhagens = containerCategorias.querySelector('.categoria-btn');
            containerCategorias.innerHTML = '';
            containerCategorias.appendChild(btnFolhagens);

            categorias.forEach(categoria => {
                const btn = document.createElement('button');
                btn.className = 'categoria-btn';
                btn.onclick = () => filtrarCategoria(categoria.id);
                btn.innerHTML = `${categoria.nome}`;
                btn.setAttribute('data-categoria-id', categoria.id);
                
                if (categoria.cor) {
                    btn.style.backgroundColor = categoria.cor;
                    btn.style.borderColor = categoria.cor;
                    btn.style.color = 'white';
                }
                
                containerCategorias.appendChild(btn);
            });
            
            console.log(`✅ ${categorias.length} categorias renderizadas`);
            inicializarGestosCategorias();
        }

        function filtrarCategoria(categoriaId) {
            categoriaAtiva = categoriaId;
            
            document.querySelectorAll('.categoria-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            event.target.classList.add('active');
            scrollarParaCategoriaAtiva();
            renderizarProdutos();
        }

        function navegarCategorias(direcao) {
            const categoriasEl = document.getElementById('categoriasCarrossel');
            if (!categoriasEl) return;
            
            const scrollAmount = 150;
            categoriasEl.scrollBy({
                left: direcao * scrollAmount,
                behavior: 'smooth'
            });
        }

        function scrollarParaCategoriaAtiva() {
            const categoriasEl = document.getElementById('categoriasCarrossel');
            const categoriaAtiva = categoriasEl.querySelector('.categoria-btn.active');
            
            if (categoriaAtiva) {
                setTimeout(() => {
                    categoriaAtiva.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest',
                        inline: 'center'
                    });
                }, 100);
            }
        }

        function inicializarGestosCategorias() {
            const categoriasEl = document.getElementById('categoriasCarrossel');
            if (!categoriasEl) return;
            
            let isDragging = false;
            let startX;
            let scrollLeft;

            categoriasEl.addEventListener('mousedown', (e) => {
                isDragging = true;
                startX = e.pageX - categoriasEl.offsetLeft;
                scrollLeft = categoriasEl.scrollLeft;
                categoriasEl.style.cursor = 'grabbing';
                categoriasEl.style.scrollBehavior = 'auto';
            });

            categoriasEl.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
                const x = e.pageX - categoriasEl.offsetLeft;
                const walk = (x - startX) * 2;
                categoriasEl.scrollLeft = scrollLeft - walk;
            });

            categoriasEl.addEventListener('mouseup', () => {
                isDragging = false;
                categoriasEl.style.cursor = 'grab';
                categoriasEl.style.scrollBehavior = 'smooth';
            });

            categoriasEl.addEventListener('mouseleave', () => {
                isDragging = false;
                categoriasEl.style.cursor = 'grab';
            });

            categoriasEl.addEventListener('touchstart', (e) => {
                isDragging = true;
                startX = e.touches[0].pageX - categoriasEl.offsetLeft;
                scrollLeft = categoriasEl.scrollLeft;
                categoriasEl.style.scrollBehavior = 'auto';
            }, { passive: true });

            categoriasEl.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                const x = e.touches[0].pageX - categoriasEl.offsetLeft;
                const walk = (x - startX) * 2;
                categoriasEl.scrollLeft = scrollLeft - walk;
            }, { passive: true });

            categoriasEl.addEventListener('touchend', () => {
                isDragging = false;
                categoriasEl.style.scrollBehavior = 'smooth';
            }, { passive: true });
        }

        // ========== PRODUTOS ==========
        async function carregarProdutos() {
            const caminhosAPI = [
                'backend/api/produtos.php',
                'api/produtos.php',
                '../backend/api/produtos.php',
                './backend/api/produtos.php',
                '/backend/api/produtos.php'
            ];

            let produtosCarregados = false;

            for (let caminho of caminhosAPI) {
                try {
                    console.log('🔄 Tentando API:', caminho);
                    
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), CONFIG.TIMEOUT_API);
                    
                    const response = await fetch(caminho, { 
                        signal: controller.signal 
                    });
                    
                    clearTimeout(timeoutId);
                    
                    if (!response.ok) continue;
                    
                    const data = await response.json();
                    console.log('✅ API encontrada em:', caminho);
                    
                    if (data.success && data.data) {
                        produtos = data.data.filter(produto => produto.ativo === 1 || produto.ativo === true);
                        console.log(`📦 ${produtos.length} produtos ATIVOS carregados da API`);
                        produtosCarregados = true;
                        await carregarCategorias();
                        break;
                    }
                } catch (error) {
                    console.log('❌ Falha na API:', caminho, error.message);
                }
            }
            
            if (!produtosCarregados) {
                console.log('🔄 Usando produtos locais como fallback');
                produtos = CONFIG.PRODUTOS_LOCAIS;
                await carregarCategorias();
                mostrarToast('⚠️ Modo offline ativado - usando catálogo local', 'aviso');
            }
            
            renderizarProdutos();
            atualizarCarrinho();
        }

function renderizarProdutos() {
    const container = document.getElementById('produtos-container');
    
    if (!container) {
        console.error('❌ Container de produtos não encontrado');
        return;
    }
    
    let produtosFiltrados = produtos;
    if (categoriaAtiva !== 'todos') {
        produtosFiltrados = produtos.filter(p => p.categoria_id == categoriaAtiva);
    }
    
    if (produtosFiltrados.length === 0) {
        container.innerHTML = '<div class="loading">😔 Nenhum produto encontrado nesta categoria</div>';
        return;
    }
    
    container.innerHTML = '';
    container.className = 'produtos-grid';

    produtosFiltrados.forEach(produto => {
        const card = document.createElement('div');
        card.className = `produto-card imagem-medio`;
        
        const categoriaInfo = categorias.find(c => c.id == produto.categoria_id) || {
            nome: produto.categoria_nome || 'Produtos',
            emoji: '',
            cor: '#70a60f'
        };
        
        // ✅ OBTER FORMAS DE VENDA DINAMICAMENTE
        const formasDisponiveis = getFormasVendaProduto(produto);
        const formasHTML = formasDisponiveis.map(forma => {
            const preco = getPrecoFormaVenda(produto, forma.nome);
            return `${forma.emoji} R$ ${preco.toFixed(2)}/${forma.sigla.toLowerCase()}`;
        }).join(' • ');
        
        // ✅ IMAGEM DO PRODUTO
        const imagemProduto = getImagemProduto(produto);
        const imagemHTML = `
            <div class="produto-imagem-container">
                ${imagemProduto.startsWith('data:') ? `
                    <div class="produto-imagem-placeholder">
                        ${getEmojiCategoria(produto.categoria_id)}
                    </div>
                ` : `
                    <img src="${imagemProduto}" 
                         alt="${escapeHtml(produto.nome)}" 
                         class="produto-imagem"
                         loading="lazy"
                         onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\"produto-imagem-placeholder\">${getEmojiCategoria(produto.categoria_id)}</div>
                `}
            </div>
        `;
        
        // ✅ INFORMAÇÕES DO PRODUTO
        const infoHTML = `
            <div class="produto-info">
                <div class="produto-categoria" style="background: ${categoriaInfo.cor || '#e8f5e8'}; color: ${categoriaInfo.cor ? 'white' : '#70a60f'}">
                    ${escapeHtml(categoriaInfo.nome)}
                </div>
                <div class="produto-nome">${escapeHtml(produto.nome)}</div>
                <div class="produto-preco">R$ ${(produto.preco_base || 0).toFixed(2)}</div>
                ${formasDisponiveis.length > 0 ? `<div class="produto-formas">${formasHTML}</div>` : ''}
                ${produto.estoque ? `<div class="produto-estoque">${produto.estoque} ${formasDisponiveis[0]?.sigla || 'un'}</div>` : ''}
                ${produto.origem ? `<div class="produto-origem">📍 ${escapeHtml(produto.origem)}</div>` : ''}
                <button class="btn-comprar" onclick="abrirModalCompra(${produto.id})">
                    🛒 Comprar Agora
                </button>
            </div>
        `;
        
        card.innerHTML = infoHTML + imagemHTML;
        container.appendChild(card);
    });
}

// ✅ FUNÇÃO PARA OBTER IMAGEM DO PRODUTO
function getImagemProduto(produto) {
    if (!produto || !produto.imagem_principal || produto.imagem_principal.trim() === '') {
        return 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgdmlld0JveD0iMCAwIDEyMCAxMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMjAiIGhlaWdodD0iMTIwIiBmaWxsPSIjRjhGOUZBIi8+CjxwYXRoIGQ9Ik02MCA0MEg1MFYzMEg0NVY0MEgzNVY0NUg0NVY1NUg1MFY0NUg2MFY0MFoiIGZpbGw9IiM3MGE2MGYiLz4KPC9zdmc+';
    }
    
    const img = produto.imagem_principal;
    
    // Se já é uma URL completa
    if (img.startsWith('http') || img.startsWith('data:') || img.startsWith('/')) {
        return img;
    }
    
    // Caminho relativo para a pasta de uploads
    return 'backend/uploads/produtos/' + img;
}

// ✅ FUNÇÃO PARA OBTER EMOJI DA CATEGORIA
function getEmojiCategoria(categoriaId) {
    const categoria = categorias.find(c => c.id == categoriaId);
    if (categoria && categoria.emoji) {
        return categoria.emoji;
    }
    
    // Emojis padrão por categoria
    const emojisPadrao = {
        'hortalicas': '',
        'frutas': '', 
        'temperos': '',
        'legumes': '',
        'verduras': '',
        'organicos': ''
    };
    
    const categoriaNome = categorias.find(c => c.id == categoriaId)?.nome?.toLowerCase();
    return emojisPadrao[categoriaNome] || '';
}

// ✅ SELEÇÃO ÚNICA POR TIPO - Cliente escolhe um valor por tipo, mas pode escolher múltiplos tipos
function selecionarVariacaoUnicaPorTipo(botao, variacaoId, tipo, valor, precoAdicional = 0) {
    console.log('🎯 Selecionando variação:', { variacaoId, tipo, valor, precoAdicional });
    
    // Desselecionar todas as variações do MESMO TIPO
    const outrosBotoes = document.querySelectorAll(`.variacao-btn-multipla[data-tipo="${tipo}"]`);
    outrosBotoes.forEach(btn => {
        btn.classList.remove('selecionado');
        btn.style.background = '';
        btn.style.color = '';
        btn.style.borderColor = '';
    });
    
    // Selecionar a variação clicada
    botao.classList.add('selecionado');
    botao.style.background = '#70a60f';
    botao.style.color = 'white';
    botao.style.borderColor = '#70a60f';
    
    // Atualizar objeto de variações selecionadas (um valor por tipo)
    variacoesSelecionadas[tipo] = {
        id: variacaoId,
        valor: valor,
        tipo: tipo,
        preco_adicional: precoAdicional || 0
    };
    
    console.log('✅ Variações selecionadas:', variacoesSelecionadas);
    atualizarContadorVariacoes();
    validarQuantidade();
}

// ✅ ATUALIZAR CONTADOR DE VARIAÇÕES SELECIONADAS
function atualizarContadorVariacoes() {
    const totalTiposSelecionados = Object.keys(variacoesSelecionadas).length;
    
    console.log(`📊 Tipos de variação selecionados: ${totalTiposSelecionados}`);
    
    // Mostrar contador na UI
    const contadorElement = document.getElementById('contadorVariacoes');
    if (contadorElement) {
        if (totalTiposSelecionados > 0) {
            const tipos = Object.keys(variacoesSelecionadas).map(tipo => 
                `${getEmojiVariacao(tipo)} ${variacoesSelecionadas[tipo].valor}`
            ).join(', ');
            
            contadorElement.innerHTML = `
                <div style="background: #70a60f; color: white; padding: 8px 12px; border-radius: 8px; font-size: 0.85rem;">
                    <strong>🎯 Selecionado:</strong> ${tipos}
                </div>
            `;
        } else {
            contadorElement.innerHTML = `
                <div style="background: #f8f9fa; color: #6c757d; padding: 8px 12px; border-radius: 8px; font-size: 0.85rem; border: 1px dashed #dee2e6;">
                    ⚠️ Nenhuma variação selecionada (opcional)
                </div>
            `;
        }
    }
}

// ========== MODAL DE COMPRA ==========
// ✅ ATUALIZAR A FUNÇÃO abrirModalCompra (parte das variações)
async function abrirModalCompra(produtoId) {
    produtoSelecionado = produtos.find(p => p.id === produtoId);
    if (!produtoSelecionado) return;
    
    let variacoes = [];
    try {
        const response = await fetch(`backend/api/variacoes.php?produto_id=${produtoId}`);
        const data = await response.json();
        if (data.success && data.data) {
            variacoes = data.data.filter(v => v.ativo);
            console.log(`🎨 ${variacoes.length} variações carregadas para ${produtoSelecionado.nome}`);
        }
    } catch (error) {
        console.log('ℹ️ Nenhuma variação encontrada ou erro na API');
    }
    
    // ✅ OBTER FORMAS DE VENDA DINAMICAMENTE
    const formasDisponiveis = getFormasVendaProduto(produtoSelecionado);
    
    const modalConteudo = document.getElementById('modalCompraConteudo');
    modalConteudo.textContent = '';
    
    // ✅ SEÇÃO DE VARIAÇÕES COM SELEÇÃO ÚNICA POR TIPO
    let variacoesHTML = '';
    if (variacoes.length > 0) {
        // Limpar seleções anteriores
    limparSelecoesVariacoes();
        
        // Agrupar variações por tipo
        const variacoesPorTipo = {};
        variacoes.forEach(variacao => {
            if (!variacoesPorTipo[variacao.nome_variacao]) {
                variacoesPorTipo[variacao.nome_variacao] = [];
            }
            variacoesPorTipo[variacao.nome_variacao].push(variacao);
        });
        
    variacoesHTML = `
        <div class="variacoes-group" style="margin-bottom: 15px;">
            <div style="margin-bottom: 12px;">
                <h4 style="margin: 0 0 8px 0; color: #333; font-size: 1.1rem;">🎨 Personalizar</h4>
                <p style="margin: 0; color: #666; font-size: 0.85rem;">
                    Escolha um valor para cada tipo (opcional)
                </p>
            </div>
            
            <div id="contadorVariacoes" style="margin-bottom: 15px;">
                <!-- Contador será preenchido dinamicamente -->
            </div>
                
               ${Object.keys(variacoesPorTipo).map(tipo => {
                const variacoesDoTipo = variacoesPorTipo[tipo];
                return `
                    <div style="margin-bottom: 15px; padding: 12px; background: #f8fff8; border-radius: 6px; border: 1px solid #e8f5e8;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 0.95rem;">
                            ${getEmojiVariacao(tipo)} ${formatarTipoVariacao(tipo)}
                            <span style="font-weight: normal; color: #666; font-size: 0.8rem;">
                                (escolha uma)
                            </span>
                        </label>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            ${variacoesDoTipo.map(variacao => `
                                <button type="button" 
                                        class="variacao-btn-compact" 
                                        data-tipo="${tipo}"
                                        data-variacao-id="${variacao.id}"
                                        onclick="selecionarVariacaoUnicaPorTipo(this, ${variacao.id}, '${tipo}', '${variacao.valor_variacao}', ${variacao.preco_adicional || 0})">
                                    ${variacao.valor_variacao}
                                    ${variacao.preco_adicional > 0 ? `
                                        <span style="font-size: 0.75em; color: #28a745; margin-left: 2px;">
                                            +${variacao.preco_adicional.toFixed(2)}
                                        </span>
                                    ` : ''}
                                </button>
                            `).join('')}
                        </div>
                    </div>
                `;
            }).join('')}
        </div>
    `;
    
    // Inicializar contador
    atualizarContadorVariacoes();
}
    
    let formasHTML = '';
    if (formasDisponiveis.length > 0) {
        formasHTML = `
            <div class="form-group">
                <label class="form-label">Forma de Venda *</label>
                
                <div class="aviso-forma-venda" id="avisoFormaVenda" style="display: none;">
                    <div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; padding: 10px 15px; margin-bottom: 15px;">
                        <div style="display: flex; align-items: center; gap: 8px; color: #721c24; font-size: 0.9rem;">
                            <span style="font-size: 1.1rem;">⚠️</span>
                            <span><strong>Selecione uma forma de venda para continuar</strong></span>
                        </div>
                    </div>
                </div>
                
                <div class="aviso-unidade" id="avisoUnidade" style="display: none;">
                    <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 10px 15px; margin-bottom: 15px;">
                        <div style="display: flex; align-items: center; gap: 8px; color: #856404; font-size: 0.9rem;">
                            <span style="font-size: 1.1rem;">💡</span>
                            <span><strong>Aproximadamente:</strong> O valor unitário é baseado no peso médio do produto</span>
                        </div>
                    </div>
                </div>
                
                <div class="formas-venda-group">
                    ${formasDisponiveis.map(forma => {
                        const preco = getPrecoFormaVenda(produtoSelecionado, forma.nome);
                        const isUnidade = forma.nome === 'unidade';
                        return `
                        <div class="forma-venda-option">
                            <button type="button" class="forma-venda-btn" 
                                    onclick="selecionarFormaVenda('${forma.nome}')"
                                    id="btnForma-${forma.nome}"
                                    data-forma="${forma.nome}">
                                ${forma.emoji} ${forma.sigla} - R$ ${preco.toFixed(2)}
                            </button>
                        </div>
                        `;
                    }).join('')}
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" id="labelQuantidade">Quantidade *</label>
                <input type="number" class="quantidade-input" id="quantidade" 
                       step="0.1" 
                       min="0.1" placeholder="0.0" required
                       oninput="validarQuantidade()">
            </div>
        `;
    }
    
    const observacoesHTML = produtoSelecionado.permite_observacoes ? `
        <div class="form-group">
            <label class="form-label">Observações (opcional)</label>
            <textarea class="form-control" id="observacoesProduto" 
                      placeholder="Alguma observação sobre este produto?"></textarea>
        </div>
    ` : '';
    
    document.getElementById('modalProdutoNome').textContent = produtoSelecionado.nome;
modalConteudo.innerHTML = `
    ${variacoesHTML}
    ${formasHTML}
    ${observacoesHTML}
    <div class="modal-actions">
        <button type="button" class="btn btn-secondary" onclick="fecharModalCompra()">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="adicionarAoCarrinho()" id="btnAdicionarCarrinho">
            ✅ Adicionar ao Carrinho
        </button>
    </div>
`;
    
    document.getElementById('modalCompra').style.display = 'block';
    formaVendaSelecionada = null;
    variacaoSelecionada = null;
}

// ✅ TOGGLE VARIAÇÃO SIMPLIFICADO
function toggleVariacao(botao, variacaoId, tipo, valor) {
    const jaSelecionado = botao.classList.contains('selecionado');
    
    if (jaSelecionado) {
        // Desselecionar
        botao.classList.remove('selecionado');
        variacaoSelecionada = null;
    } else {
        // Selecionar - desseleciona outros do mesmo tipo primeiro
        const outrosBotoes = document.querySelectorAll(`.variacao-btn-simples[data-variacao-id="${variacaoId}"]`);
        outrosBotoes.forEach(btn => btn.classList.remove('selecionado'));
        
        // Seleciona este
        botao.classList.add('selecionado');
        variacaoSelecionada = {
            id: variacaoId,
            tipo: tipo,
            valor: valor
        };
    }
    
    console.log('🎯 Variação selecionada:', variacaoSelecionada);
}
        function fecharModalCompra() {
            document.getElementById('modalCompra').style.display = 'none';
            tipoEntregaSelecionado = null;
            document.querySelectorAll('.forma-entrega-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById('avisoDelivery').style.display = 'none';
            produtoSelecionado = null;
            formaVendaSelecionada = null;
        }

function selecionarFormaVenda(formaNome) {
    formaVendaSelecionada = formaNome;
    
    // Remover active de todos os botões
    document.querySelectorAll('.forma-venda-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Adicionar active ao botão clicado
    const btnSelecionado = document.getElementById(`btnForma-${formaNome}`);
    if (btnSelecionado) {
        btnSelecionado.classList.add('active');
    }
    
    // ✅ OBTER INFORMAÇÕES DA FORMA DE VENDA
    const formaInfo = formasVenda.find(f => f.nome === formaNome);
    
    // ✅ OCULTAR AVISO QUANDO FORMA FOR SELECIONADA
    const avisoFormaVenda = document.getElementById('avisoFormaVenda');
    if (avisoFormaVenda) {
        avisoFormaVenda.style.display = 'none';
        
        document.querySelectorAll('.forma-venda-btn').forEach(btn => {
            btn.style.border = '';
            btn.style.boxShadow = '';
            btn.classList.remove('pulse-animation');
        });
    }
    
    const inputQuantidade = document.getElementById('quantidade');
    const labelQuantidade = document.getElementById('labelQuantidade');
    const avisoUnidade = document.getElementById('avisoUnidade');
    
    // ✅ CONFIGURAR INPUT BASEADO NA FORMA DE VENDA
    if (formaNome === 'kg') {
        inputQuantidade.step = '0.1';
        inputQuantidade.min = '0.1';
        inputQuantidade.placeholder = '0.0';
        labelQuantidade.textContent = `Quantidade (${formaInfo?.sigla || 'Kg'}) *`;
    } else {
        inputQuantidade.step = '1';
        inputQuantidade.min = '1';
        inputQuantidade.placeholder = '0';
        labelQuantidade.textContent = `Quantidade (${formaInfo?.sigla || 'Un'}) *`;
    }
    
    if (avisoUnidade) {
        avisoUnidade.style.display = formaNome === 'unidade' ? 'block' : 'none';
    }
    
    inputQuantidade.value = '';
    validarQuantidade();
}

function validarQuantidade() {
    const inputQuantidade = document.getElementById('quantidade');
    const quantidade = parseFloat(inputQuantidade?.value) || 0;
    const btnAdicionar = document.getElementById('btnAdicionarCarrinho');
    
    if (!btnAdicionar) return;
    
    const temVariacoes = document.querySelector('.variacoes-group') !== null;
    const variacaoObrigatoriaSelecionada = !temVariacoes || Object.keys(variacoesSelecionadas).length > 0;
    
    // Verificar se forma de venda foi selecionada
    const formaSelecionada = formaVendaSelecionada !== null;
    
    // Apenas mudar a aparência para indicar status
    if (quantidade > 0 && formaSelecionada && variacaoObrigatoriaSelecionada) {
        btnAdicionar.style.opacity = '1';
        btnAdicionar.style.cursor = 'pointer';
    } else {
        btnAdicionar.style.opacity = '0.6';
        btnAdicionar.style.cursor = 'not-allowed';
    }
}

// ✅ FUNÇÃO PARA DESSELECIONAR UM TIPO ESPECÍFICO
function desselecionarTipoVariacao(tipo) {
    if (variacoesSelecionadas[tipo]) {
        // Desselecionar visualmente todos os botões deste tipo
        const botoesTipo = document.querySelectorAll(`.variacao-btn-compact [data-tipo="${tipo}"]`);
        botoesTipo.forEach(btn => {
            btn.classList.remove('selecionado');
            btn.style.background = '';
            btn.style.color = '';
            btn.style.borderColor = '';
        });
        
        // Remover do objeto de variações selecionadas
        delete variacoesSelecionadas[tipo];
        
        console.log(`🗑️ Variação do tipo ${tipo} removida`);
        atualizarContadorVariacoes();
        validarQuantidade();
    }
}

// ✅ CSS COMPACTO PARA VARIAÇÕES
const estiloVariacoesCompacto = `
    .variacao-btn-compact {
        padding: 8px 12px;
        border: 1.5px solid #e0e0e0;
        background: white;
        color: #666;
        border-radius: 20px;
        cursor: pointer;
        font-size: 0.85rem;
        transition: all 0.2s ease;
        font-weight: 500;
        position: relative;
        line-height: 1.2;
    }
    
    .variacao-btn-compact:hover {
        border-color: #70a60f;
        color: #70a60f;
        transform: translateY(-1px);
    }
    
    .variacao-btn-compact.selecionado {
        background: #70a60f !important;
        color: white !important;
        border-color: #70a60f !important;
        transform: translateY(-1px);
        box-shadow: 0 1px 4px rgba(112, 166, 15, 0.3);
    }
    
    .variacoes-group {
        border: 1px solid #e8f5e8;
        border-radius: 8px;
        padding: 15px;
        background: #f8fff8;
        margin-bottom: 15px;
    }
    
    #contadorVariacoes {
        transition: all 0.3s ease;
        font-size: 0.85rem;
    }
`;

// ✅ ATUALIZAR CSS NO DOCUMENTO
if (document.querySelector('#estilo-variacoes')) {
    document.querySelector('#estilo-variacoes').remove();
}

const style = document.createElement('style');
style.id = 'estilo-variacoes';
style.textContent = estiloVariacoesCompacto;
document.head.appendChild(style);

// ✅ MANTER FUNÇÃO DE LIMPEZA
function limparSelecoesVariacoes() {
    document.querySelectorAll('.variacao-btn-multipla').forEach(btn => {
        btn.classList.remove('selecionado');
        btn.style.background = '';
        btn.style.color = '';
        btn.style.borderColor = '';
    });
    variacoesSelecionadas = {};
    atualizarContadorVariacoes();
    console.log('🔄 Todas as variações desselecionadas');
}

        function toggleVariacao(botao, variacaoId, tipo, valor) {
            const jaSelecionado = botao.classList.contains('selecionado');
            
            if (jaSelecionado) {
                botao.classList.remove('selecionado');
                variacaoSelecionada = null;
            } else {
                const outrosBotoes = document.querySelectorAll(`.variacao-btn-simples[data-variacao-id="${variacaoId}"]`);
                outrosBotoes.forEach(btn => btn.classList.remove('selecionado'));
                
                botao.classList.add('selecionado');
                variacaoSelecionada = {
                    id: variacaoId,
                    tipo: tipo,
                    valor: valor
                };
            }
            
            console.log('🎯 Variação selecionada:', variacaoSelecionada);
        }

        function formatarTipoVariacao(tipo) {
            const formatos = {
                'tamanho': '📏 Tamanho',
                'cor': '🎨 Cor', 
                'volume': '📦 Volume',
                'sabor': '👅 Sabor',
                'outro': '🔧 Outro'
            };
            return formatos[tipo] || tipo;
        }

        function getEmojiVariacao(tipo) {
            const emojis = {
                'tamanho': '📏',
                'cor': '🎨',
                'volume': '📦', 
                'sabor': '👅',
                'outro': '🔧'
            };
            return emojis[tipo] || '🔘';
        }

        // ========== CARRINHO ==========
// ✅ ATUALIZAR A FUNÇÃO adicionarAoCarrinho
function adicionarAoCarrinho() {
    console.log('🛒 Tentando adicionar ao carrinho...');
    
    // ✅ VALIDAÇÃO COMPLETA NO CLIQUE
    const inputQuantidade = document.getElementById('quantidade');
    const quantidade = parseFloat(inputQuantidade?.value) || 0;
    
    // 1. Verificar forma de venda
    if (!formaVendaSelecionada) {
        console.log('🚨 Forma de venda não selecionada');
        const aviso = document.getElementById('avisoFormaVenda');
        if (aviso) {
            aviso.style.display = 'block';
            aviso.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        mostrarToast('❌ Por favor, selecione uma forma de venda!', 'erro');
        return;
    }
    
    // 2. Verificar quantidade
    if (!quantidade || quantidade <= 0) {
        mostrarToast('❌ Por favor, informe uma quantidade válida!', 'erro');
        return;
    }
    
    // ✅ VARIAÇÕES SÃO OPCIONAIS - NÃO PRECISA VALIDAR
    
    // ✅ SE PASSOU EM TODAS AS VALIDAÇÕES, ADICIONA AO CARRINHO
    if (!produtoSelecionado) return;
    
    const observacoesElement = document.getElementById('observacoesProduto');
    const observacoes = observacoesElement ? observacoesElement.value : '';
    
    let precoBase = produtoSelecionado.precos && produtoSelecionado.precos[formaVendaSelecionada] 
        ? produtoSelecionado.precos[formaVendaSelecionada] 
        : produtoSelecionado.preco_base;
    
    // ✅ CALCULAR PREÇO TOTAL COM ACRÉSCIMOS DAS VARIAÇÕES
    let precoFinal = precoBase;
    let totalAcrescimos = 0;
    
    if (Object.keys(variacoesSelecionadas).length > 0) {
        Object.values(variacoesSelecionadas).forEach(variacao => {
            if (variacao.preco_adicional && variacao.preco_adicional > 0) {
                precoFinal += variacao.preco_adicional;
                totalAcrescimos += variacao.preco_adicional;
            }
        });
    }
    
    // ✅ CONSTRUIR DETALHES DAS VARIAÇÕES
    let detalhesVariacoes = '';
    if (Object.keys(variacoesSelecionadas).length > 0) {
        detalhesVariacoes = Object.values(variacoesSelecionadas)
            .map(v => `${formatarTipoVariacao(v.tipo)}: ${v.valor}`)
            .join(' | ');
    }
    
    // ✅ CONSTRUIR OBSERVAÇÕES FINAIS
    let observacoesFinais = observacoes;
    if (detalhesVariacoes) {
        if (observacoesFinais) {
            observacoesFinais += ` | ${detalhesVariacoes}`;
        } else {
            observacoesFinais = detalhesVariacoes;
        }
    }
    
    const itemCarrinho = {
        id: produtoSelecionado.id,
        nome: produtoSelecionado.nome,
        preco: precoFinal, // ✅ PREÇO COM ACRÉSCIMOS DAS VARIAÇÕES
        quantidade: quantidade,
        tipo_venda: formaVendaSelecionada,
        observacao: observacoesFinais,
        produto: produtoSelecionado,
        variacoes: JSON.parse(JSON.stringify(variacoesSelecionadas)), // Deep copy das variações
        preco_base: precoBase, // ✅ GUARDAR PREÇO BASE PARA REFERÊNCIA
        acrescimos: totalAcrescimos // ✅ VALOR TOTAL DOS ACRÉSCIMOS
    };
    
    carrinho.push(itemCarrinho);
    salvarCarrinho();
    atualizarCarrinho();
    fecharModalCompra();
    
    let mensagem = `✅ ${produtoSelecionado.nome} adicionado ao carrinho!`;
    if (detalhesVariacoes) {
        mensagem += ` (${detalhesVariacoes})`;
    }
    if (precoFinal > precoBase) {
        mensagem += ` - Total: R$ ${precoFinal.toFixed(2)}`;
    }
    
    mostrarToast(mensagem, 'sucesso');
    formaVendaSelecionada = null;
    variacoesSelecionadas = {};
}

// ✅ FUNÇÃO ESPECÍFICA PARA MOSTRAR O AVISO
function mostrarAvisoFormaVenda() {
    console.log('🚨 MOSTRANDO AVISO - Forma de venda não selecionada');
    
    const avisoFormaVenda = document.getElementById('avisoFormaVenda');
    
    if (avisoFormaVenda) {
        console.log('✅ Elemento do aviso encontrado');
        
        // Mostrar o aviso
        avisoFormaVenda.style.display = 'block';
        
        // Rolagem suave para o aviso
        avisoFormaVenda.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'center' 
        });
        
        // Efeito de destaque nos botões de forma de venda
        document.querySelectorAll('.forma-venda-btn').forEach(btn => {
            btn.style.border = '2px solid #dc3545';
            btn.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.2)';
            btn.classList.add('pulse-animation');
        });
        
        console.log('✅ Aviso exibido e botões destacados');
    } else {
        console.log('❌ Elemento do aviso NÃO encontrado');
    }
    
    mostrarToast('❌ Por favor, selecione uma forma de venda!', 'erro');
}

        function atualizarCarrinho() {
            const contador = document.getElementById('carrinhoContador');
            const totalElement = document.getElementById('carrinhoTotal');
            const itensContainer = document.getElementById('carrinhoItens');
            const btnFinalizar = document.getElementById('btnFinalizar');
            
            if (contador) contador.textContent = carrinho.length;
            
            const total = carrinho.reduce((sum, item) => sum + (item.preco * item.quantidade), 0);
            if (totalElement) totalElement.textContent = total.toFixed(2);
            
            if (itensContainer) {
                if (carrinho.length === 0) {
                    itensContainer.innerHTML = '<div style="text-align: center; padding: 20px; color: #666;">Seu carrinho está vazio</div>';
                    if (btnFinalizar) btnFinalizar.disabled = true;
                } else {
                    itensContainer.innerHTML = carrinho.map((item, index) => {
                        const subtotal = item.preco * item.quantidade;
                        const unidades = { 'kg': 'kg', 'unidade': 'un', 'maco': 'maço' };
                        const unidade = unidades[item.tipo_venda] || 'un';
                        
                        return `
                            <div class="carrinho-item">
                                <div class="carrinho-item-info">
                                    <div class="carrinho-item-nome">${escapeHtml(item.nome)}</div>
                                    <div class="carrinho-item-detalhes">
                                        ${item.quantidade} ${unidade} × R$ ${item.preco.toFixed(2)}
                                        ${item.observacao ? `<br>📝 ${escapeHtml(item.observacao)}` : ''}
                                        <br><strong>Subtotal: R$ ${subtotal.toFixed(2)}</strong>
                                    </div>
                                </div>
                                <div class="carrinho-item-acoes">
                                    <button class="btn-editar" onclick="editarItemCarrinho(${index})" title="Editar item">
                                        ✏️ Editar
                                    </button>
                                    <button class="btn-remover" onclick="removerItemCarrinho(${index})" title="Remover item">
                                        🗑️ Remover
                                    </button>
                                </div>
                            </div>
                        `;
                    }).join('');
                    if (btnFinalizar) btnFinalizar.disabled = false;
                }
            }
        }

function editarItemCarrinho(index) {
    const item = carrinho[index];
    produtoSelecionado = item.produto;
    
    document.getElementById('carrinhoFixo').classList.remove('carrinho-aberto');
    
    // ✅ OBTER FORMAS DE VENDA DINAMICAMENTE
    const formasDisponiveis = getFormasVendaProduto(produtoSelecionado);
    
    const modalConteudo = document.getElementById('modalCompraConteudo');
    modalConteudo.textContent = '';
    
    let formasHTML = '';
    if (formasDisponiveis.length > 0) {
        formasHTML = `
            <div class="form-group">
                <label class="form-label">Forma de Venda *</label>
                
                <div class="aviso-forma-venda" id="avisoFormaVenda" style="display: none;">
                    <div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; padding: 10px 15px; margin-bottom: 15px;">
                        <div style="display: flex; align-items: center; gap: 8px; color: #721c24; font-size: 0.9rem;">
                            <span style="font-size: 1.1rem;">⚠️</span>
                            <span><strong>Selecione uma forma de venda para continuar</strong></span>
                        </div>
                    </div>
                </div>
                
                <div class="aviso-unidade" id="avisoUnidade" style="display: ${item.tipo_venda === 'unidade' ? 'block' : 'none'};">
                    <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 10px 15px; margin-bottom: 15px;">
                        <div style="display: flex; align-items: center; gap: 8px; color: #856404; font-size: 0.9rem;">
                            <span style="font-size: 1.1rem;">💡</span>
                            <span><strong>Aproximadamente:</strong> O valor unitário é baseado no peso médio do produto</span>
                        </div>
                    </div>
                </div>
                
                <div class="formas-venda-group">
                    ${formasDisponiveis.map(forma => {
                        const preco = getPrecoFormaVenda(produtoSelecionado, forma.nome);
                        const isActive = forma.nome === item.tipo_venda;
                        return `
                        <div class="forma-venda-option">
                            <button type="button" class="forma-venda-btn ${isActive ? 'active' : ''}" 
                                    onclick="selecionarFormaVenda('${forma.nome}')"
                                    id="btnForma-${forma.nome}"
                                    data-forma="${forma.nome}">
                                ${forma.emoji} ${forma.sigla} - R$ ${preco.toFixed(2)}
                            </button>
                        </div>
                        `;
                    }).join('')}
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" id="labelQuantidade">Quantidade *</label>
                <input type="number" class="quantidade-input" id="quantidade" 
                       value="${item.quantidade}"
                       step="${item.tipo_venda === 'kg' ? '0.1' : '1'}" 
                       min="${item.tipo_venda === 'kg' ? '0.1' : '1'}" 
                       placeholder="${item.tipo_venda === 'kg' ? '0.0' : '0'}" 
                       required>
            </div>
        `;
    }
    
    const observacoesHTML = produtoSelecionado.permite_observacoes ? `
        <div class="form-group">
            <label class="form-label">Observações (opcional)</label>
            <textarea class="form-control" id="observacoesProduto">${item.observacao || ''}</textarea>
        </div>
    ` : '';
    
    document.getElementById('modalProdutoNome').textContent = `Editar: ${produtoSelecionado.nome}`;
    modalConteudo.innerHTML = `
        ${formasHTML}
        ${observacoesHTML}
        <div class="modal-actions">
            <button type="button" class="btn btn-secondary" onclick="fecharModalCompra()">Cancelar</button>
            <button type="button" class="btn btn-warning" onclick="atualizarItemCarrinho(${index})" id="btnAtualizarCarrinho">
                ✏️ Atualizar Item
            </button>
        </div>
    `;
    
    formaVendaSelecionada = item.tipo_venda;
    document.getElementById('modalCompra').style.display = 'block';
    document.getElementById('btnAtualizarCarrinho').disabled = false;
}

        function atualizarItemCarrinho(index) {
            if (!produtoSelecionado || !formaVendaSelecionada) return;
            
            const quantidade = parseFloat(document.getElementById('quantidade').value);
            const observacoes = document.getElementById('observacoesProduto')?.value || '';
            
            if (quantidade <= 0) {
                mostrarToast('❌ Por favor, informe uma quantidade válida!', 'erro');
                return;
            }
            
            const preco = produtoSelecionado.precos[formaVendaSelecionada] || produtoSelecionado.preco_base;
            
            carrinho[index] = {
                id: produtoSelecionado.id,
                nome: produtoSelecionado.nome,
                preco: preco,
                quantidade: quantidade,
                tipo_venda: formaVendaSelecionada,
                observacao: observacoes,
                produto: produtoSelecionado
            };
            
            salvarCarrinho();
            atualizarCarrinho();
            fecharModalCompra();
            mostrarToast(`✅ ${produtoSelecionado.nome} atualizado no carrinho!`, 'sucesso');
        }

        function removerItemCarrinho(index) {
            if (confirm('Remover este item do carrinho?')) {
                const itemRemovido = carrinho[index];
                carrinho.splice(index, 1);
                salvarCarrinho();
                atualizarCarrinho();
                mostrarToast(`🗑️ ${itemRemovido.nome} removido do carrinho`, 'aviso');
            }
        }

        function toggleCarrinho() {
            document.getElementById('carrinhoFixo').classList.toggle('carrinho-aberto');
        }

// ✅ ATUALIZAR A FUNÇÃO abrirModalFinalizar
function abrirModalFinalizar() {
    if (carrinho.length === 0) {
        mostrarToast('❌ Seu carrinho está vazio!', 'erro');
        return;
    }
    
    atualizarResumoPedido();
    atualizarOpcoesPagamentoModal(); // ✅ ATUALIZAR OPÇÕES DE PAGAMENTO
    document.getElementById('modalFinalizar').style.display = 'block';
    
    setTimeout(() => {
        preencherFormularioCliente();
        inicializarValidacaoFormulario();
    }, 100);
}

        function fecharModalFinalizar() {
            document.getElementById('modalFinalizar').style.display = 'none';
        }

        function selecionarTipoEntrega(tipo) {
            tipoEntregaSelecionado = tipo;
            
            document.querySelectorAll('.forma-entrega-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            document.getElementById(`btn${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`).classList.add('active');
            
            const avisoDelivery = document.getElementById('avisoDelivery');
            if (avisoDelivery) {
                if (tipo === 'delivery') {
                    avisoDelivery.style.display = 'block';
                } else {
                    avisoDelivery.style.display = 'none';
                }
            }
            
            console.log(`🚚 Tipo de entrega selecionado: ${tipo}`);
        }

        function validarFormularioAntesDeEnviar() {
            if (!tipoEntregaSelecionado) {
                mostrarToast('❌ Por favor, selecione o tipo de entrega!', 'erro');
                return false;
            }
            return true;
        }

async function enviarPedido(event) {
    event.preventDefault();

    const btnEnviar = document.getElementById('btnEnviarPedido');
    const formData = new FormData(event.target);
    
    // Validações existentes...
    const camposObrigatorios = ['nome', 'email', 'telefone', 'cep', 'endereco', 'numero', 'forma_pagamento'];
    let camposFaltantes = [];
    
    for (let campo of camposObrigatorios) {
        const valor = formData.get(campo);
        if (!valor || valor.trim() === '') {
            camposFaltantes.push(campo);
        }
    }
    
    if (camposFaltantes.length > 0) {
        mostrarToast('❌ Preencha todos os campos obrigatórios!', 'erro');
        return;
    }
    
    if (!validarEmail(formData.get('email'))) {
        mostrarToast('❌ Por favor, insira um e-mail válido!', 'erro');
        return;
    }
    
    if (!tipoEntregaSelecionado) {
        mostrarToast('❌ Por favor, selecione o tipo de entrega!', 'erro');
        return;
    }

    const dadosParaSalvar = {
        nome: formData.get('nome').trim(),
        email: formData.get('email').trim(),
        telefone: formData.get('telefone').trim(),
        cep: formData.get('cep').trim(),
        endereco: formData.get('endereco').trim(),
        numero: formData.get('numero').trim(),
        complemento: formData.get('complemento').trim()
    };
    salvarDadosCliente(dadosParaSalvar);
    
    const enderecoCompleto = `${formData.get('endereco')}, ${formData.get('numero')}${formData.get('complemento') ? ' - ' + formData.get('complemento') : ''}`;
    
    const dadosPedido = {
        cliente: {
            nome: formData.get('nome').trim(),
            email: formData.get('email').trim(),
            telefone: formData.get('telefone').trim(),
            endereco: enderecoCompleto.trim(),
            cep: formData.get('cep').trim()
        },
        itens: carrinho.map(item => ({
            id: item.id,
            nome: item.nome,
            quantidade: item.quantidade,
            preco: item.preco,
            tipo_venda: item.tipo_venda,
            observacao: item.observacao || ''
        })),
        total: carrinho.reduce((sum, item) => sum + (item.preco * item.quantidade), 0),
        forma_pagamento: formData.get('forma_pagamento'),
        tipo_entrega: tipoEntregaSelecionado,
        observacoes: formData.get('observacoes') || ''
    };
    
    console.log('📤 Dados do pedido:', dadosPedido);
    prevenirDuploClique(btnEnviar);
    
    try {
        const response = await fetch('backend/api/pedidos.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dadosPedido)
        });
        
        const result = await response.json();
        
        if (result.success) {
            // ✅ SALVAR DADOS NA SESSÃO PARA ACOMPANHAMENTO
            sessionStorage.setItem('ultimo_pedido_id', result.pedido_id);
            sessionStorage.setItem('cliente_email', dadosPedido.cliente.email);
            
            // ✅ MOSTRAR MENSAGEM DE SUCESSO COM LINK PARA ACOMPANHAMENTO
            mostrarToast(`🎉 Pedido #${result.pedido_id} enviado com sucesso! Redirecionando...`, 'sucesso');
            
            // ✅ REDIRECIONAR PARA ACOMPANHAMENTO APÓS 2 SEGUNDOS
            setTimeout(() => {
                window.location.href = `tracking.php?pedido_id=${result.pedido_id}&email=${encodeURIComponent(dadosPedido.cliente.email)}`;
            }, 2000);
            
            // ✅ LIMPAR CARRINHO
            carrinho = [];
            salvarCarrinho();
            atualizarCarrinho();
            
        } else {
            throw new Error(result.message || 'Erro ao processar pedido');
        }
        
    } catch (error) {
        console.error('❌ Erro ao enviar pedido:', error);
        mostrarToast('❌ Erro ao enviar pedido: ' + error.message, 'erro');
    }
}

        function atualizarResumoPedido() {
            const resumoItens = document.getElementById('resumoItens');
            const resumoTotal = document.getElementById('resumoTotal');
            
            if (resumoItens && resumoTotal) {
                let html = '';
                carrinho.forEach(item => {
                    const subtotal = item.preco * item.quantidade;
                    html += `<div style="display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 0.9rem;">
                        <span>${escapeHtml(item.nome)}</span>
                        <span>${item.quantidade} ${item.tipo_venda === 'kg' ? 'kg' : 'un'} × R$ ${item.preco.toFixed(2)}</span>
                    </div>`;
                });
                
                resumoItens.innerHTML = html;
                resumoTotal.textContent = carrinho.reduce((sum, item) => sum + (item.preco * item.quantidade), 0).toFixed(2);
            }
        }

        // ========== VALIDAÇÃO DE FORMULÁRIO ==========
        function inicializarValidacaoFormulario() {
            const form = document.getElementById('formCliente');
            const campos = form.querySelectorAll('[required]');
            
            campos.forEach(campo => {
                campo.addEventListener('blur', validarCampo);
                campo.addEventListener('input', () => limparErro(campo));
            });
        }

        function validarCampo(e) {
            const campo = e.target;
            const valor = campo.value.trim();
            
            limparErro(campo);
            
            if (campo.name === 'email' && valor && !validarEmail(valor)) {
                mostrarErro(campo, 'Por favor, insira um e-mail válido');
            }
            
            if (campo.name === 'telefone' && valor && !validarTelefone(valor)) {
                mostrarErro(campo, 'Por favor, insira um telefone válido');
            }
            
            if (campo.name === 'cep' && valor && !validarCEP(valor)) {
                mostrarErro(campo, 'CEP deve ter 8 dígitos');
            }
        }

        function mostrarErro(campo, mensagem) {
            campo.classList.add('erro');
            let erroElement = campo.parentNode.querySelector('.erro-validacao');
            
            if (!erroElement) {
                erroElement = document.createElement('div');
                erroElement.className = 'erro-validacao';
                campo.parentNode.appendChild(erroElement);
            }
            
            erroElement.textContent = mensagem;
        }

        function limparErro(campo) {
            campo.classList.remove('erro');
            const erroElement = campo.parentNode.querySelector('.erro-validacao');
            if (erroElement) erroElement.remove();
        }

        // ========== CARROSSEL ==========
        function inicializarCarrossel() {
            const imagensCarrossel = [
                'https://images.unsplash.com/photo-1540420773420-3366772f4999?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
                'https://images.unsplash.com/photo-1574856344991-aaa31b6f4ce3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
                'https://images.unsplash.com/photo-1619566636858-adf3ef46400b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
                'https://images.unsplash.com/photo-1566385101042-1a0aa0c1268c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
                'https://images.unsplash.com/photo-1518977676601-b53f82aba655?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80'
            ].map(url => url);
            
            const carrosselSlides = document.getElementById('carrosselSlides');
            if (carrosselSlides) {
                carrosselSlides.innerHTML = imagensCarrossel.map(url => 
                    `<div class="carrossel-slide" style="background-image: url('${url}')"></div>`
                ).join('');
            }
            
            inicializarGestosCarrossel();
        }

        function moverCarrossel(direcao) {
            const slides = document.querySelectorAll('.carrossel-slide');
            if (slides.length > 0) {
                slideAtual = (slideAtual + direcao + slides.length) % slides.length;
                document.getElementById('carrosselSlides').style.transform = `translateX(-${slideAtual * 100}%)`;
            }
            
            reiniciarAutoPlay();
        }

        function reiniciarAutoPlay() {
            clearTimeout(timeoutCarrossel);
            timeoutCarrossel = setTimeout(() => moverCarrossel(1), 5000);
        }

        function inicializarGestosCarrossel() {
            const carrossel = document.getElementById('carrossel');
            let startX = 0;
            let currentX = 0;

            carrossel.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
            }, { passive: true });

            carrossel.addEventListener('touchmove', (e) => {
                currentX = e.touches[0].clientX;
            }, { passive: true });

            carrossel.addEventListener('touchend', () => {
                const diff = startX - currentX;
                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        moverCarrossel(1);
                    } else {
                        moverCarrossel(-1);
                    }
                }
            }, { passive: true });
        }
// ========== FORMAS DE VENDA ==========
let formasVenda = [];

async function carregarFormasVenda() {
    const caminhosAPI = [
        'backend/api/formas_venda.php',
        'api/formas_venda.php',
        '../backend/api/formas_venda.php',
        './backend/api/formas_venda.php',
        '/backend/api/formas_venda.php'
    ];

    for (let caminho of caminhosAPI) {
        try {
            console.log('🔄 Buscando formas de venda em:', caminho);
            
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), CONFIG.TIMEOUT_API);
            
            const response = await fetch(caminho, { 
                signal: controller.signal 
            });
            
            clearTimeout(timeoutId);
            
            if (!response.ok) continue;
            
            const data = await response.json();
            console.log('✅ Formas de venda encontradas em:', caminho);
            
            if (data.success && data.data) {
                // Filtrar apenas formas ativas
                formasVenda = data.data.filter(forma => forma.ativa === true || forma.ativa === 1);
                console.log(`📊 ${formasVenda.length} formas de venda carregadas:`, formasVenda);
                return true;
            }
        } catch (error) {
            console.log('❌ Falha na API de formas de venda:', caminho, error.message);
        }
    }
    
    // Fallback para formas padrão se a API falhar
    console.log('🔄 Usando formas de venda padrão como fallback');
    formasVenda = [
        { id: 1, nome: 'kg', emoji: '⚖️', sigla: 'Kg', ordem: 1, ativa: true },
        { id: 2, nome: 'unidade', emoji: '🔢', sigla: 'Un', ordem: 2, ativa: true },
        { id: 3, nome: 'maco', emoji: '📦', sigla: 'Mç', ordem: 3, ativa: true }
    ];
    
    mostrarToast('⚠️ Modo offline - usando formas de venda padrão', 'aviso');
    return false;
}

// Função auxiliar para obter formas de venda de um produto
function getFormasVendaProduto(produto) {
    if (!produto || !produto.formas_venda) return [];
    
    return formasVenda.filter(forma => {
        return produto.formas_venda[forma.nome] === true || 
               produto.formas_venda[forma.nome] === 1;
    });
}

// Função para obter preço formatado
function getPrecoFormaVenda(produto, formaNome) {
    if (produto.precos && produto.precos[formaNome]) {
        return produto.precos[formaNome];
    }
    return produto.preco_base || 0;
}
// ========== CONFIGURAÇÕES DINÂMICAS ==========
let configuracoesSite = {};

async function carregarConfiguracoes() {
    const caminhosAPI = [
        'backend/api/configuracoes.php',
        'api/configuracoes.php',
        '../backend/api/configuracoes.php',
        './backend/api/configuracoes.php',
        '/backend/api/configuracoes.php'
    ];

    for (let caminho of caminhosAPI) {
        try {
            console.log('🔄 Buscando configurações em:', caminho);
            
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), CONFIG.TIMEOUT_API);
            
            const response = await fetch(caminho, { 
                signal: controller.signal 
            });
            
            clearTimeout(timeoutId);
            
            if (!response.ok) continue;
            
            const data = await response.json();
            console.log('✅ Configurações encontradas em:', caminho);
            
            if (data.success && data.data) {
                configuracoesSite = data.data;
                
                // Salvar no cache local (5 minutos)
                localStorage.setItem('configuracoes_site', JSON.stringify({
                    data: configuracoesSite,
                    timestamp: Date.now()
                }));
                
                console.log('⚙️ Configurações carregadas:', configuracoesSite);
                aplicarConfiguracoesNoSite();
                return true;
            }
        } catch (error) {
            console.log('❌ Falha na API de configurações:', caminho, error.message);
        }
    }
    
    // Tentar usar cache local
    const cached = localStorage.getItem('configuracoes_site');
    if (cached) {
        const { data, timestamp } = JSON.parse(cached);
        const cacheTime = 5 * 60 * 1000; // 5 minutos
        
        if (Date.now() - timestamp < cacheTime) {
            console.log('⚡ Usando configurações em cache');
            configuracoesSite = data;
            aplicarConfiguracoesNoSite();
            return true;
        }
    }
    
    // Fallback para configurações padrão
    console.log('🔄 Usando configurações padrão como fallback');
    configuracoesSite = {
        site: {
            nome: 'Ouro Verde Orgânicos',
            slogan: 'Qualidade que você vê, sabor que você sente',
            email: '',
            telefone: '',
            endereco: ''
        },
        business: {
            horario_funcionamento: 'Segunda à sexta: 08:00 às 19:00 Horas | Sábado: 08:00 às 13:00 Horas',
            valor_frete_gratis: 0,
            taxa_entrega: 0,
            info_taxa_entrega: '',
            tempo_entrega: ''
        },
        seo: {
            meta_description: '',
            meta_keywords: ''
        },
        social: {
            instagram: '',
            whatsapp: ''
        },
        payment: {
            aceita_cartao: true,
            aceita_pix: true,
            aceita_dinheiro: true
        },
        theme: {
            primary_color: '#70a60f',
            secondary_color: '#5a850c',
            logo_url: '',
            enable_dark_mode: false
        },
        products: {
            show_out_of_stock: false,
            enable_reviews: false,
            max_products_per_page: 20,
            low_stock_threshold: 5,
            show_origin: true
        },
        delivery: {
            enable_delivery: true,
            enable_pickup: true,
            delivery_radius: 10,
            delivery_fee: 5,
            delivery_preparation_time: 30
        }
    };
    
    aplicarConfiguracoesNoSite();
    return false;
}

function aplicarConfiguracoesNoSite() {
    console.log('🎨 Aplicando configurações no site...');
    
    // ✅ TÍTULO E META TAGS
    document.title = `${configuracoesSite.site.nome} - Loja Online`;
    
    // ✅ META DESCRIPTION DINÂMICA
    let metaDescription = document.querySelector('meta[name="description"]');
    if (!metaDescription) {
        metaDescription = document.createElement('meta');
        metaDescription.name = 'description';
        document.head.appendChild(metaDescription);
    }
    metaDescription.content = configuracoesSite.seo.meta_description || `${configuracoesSite.site.nome} - ${configuracoesSite.site.slogan}`;
    
    // ✅ META KEYWORDS DINÂMICAS
    let metaKeywords = document.querySelector('meta[name="keywords"]');
    if (!metaKeywords) {
        metaKeywords = document.createElement('meta');
        metaKeywords.name = 'keywords';
        document.head.appendChild(metaKeywords);
    }
    metaKeywords.content = configuracoesSite.seo.meta_keywords || 'hortifruti, orgânicos, frutas, verduras, legumes';
    
    // ✅ APLICAR CONFIGURAÇÕES DE TEMA
    aplicarConfiguracoesTema();
    
    // ✅ HEADER DO SITE
    const header = document.querySelector('.header');
    if (header) {
        const titulo = header.querySelector('h1');
        const slogan = header.querySelector('p');
        
        if (titulo) titulo.textContent = configuracoesSite.site.nome;
        if (slogan) slogan.textContent = configuracoesSite.site.slogan;
    }
    
    // ✅ HORÁRIO DE FUNCIONAMENTO DINÂMICO
    atualizarHorarioFuncionamento();
    
    // ✅ INFORMAÇÕES DE ENTREGA DINÂMICAS
    atualizarInformacoesEntrega();
    
    // ✅ RODAPÉ DINÂMICO
    atualizarRodape();
    
    // ✅ BOTÃO DO WHATSAPP DINÂMICO
    atualizarWhatsApp();
    
    console.log('✅ Configurações aplicadas com sucesso!');
}
// ✅ APLICAR CONFIGURAÇÕES DE TEMA
function aplicarConfiguracoesTema() {
    if (configuracoesSite.theme) {
        const root = document.documentElement;
        
        // Aplicar cores dinâmicas
        if (configuracoesSite.theme.primary_color) {
            root.style.setProperty('--primary-color', configuracoesSite.theme.primary_color);
            // Aplicar em elementos específicos
            document.querySelectorAll('.header, .btn-comprar, .carrinho-header').forEach(el => {
                el.style.background = `linear-gradient(135deg, ${configuracoesSite.theme.primary_color}, ${configuracoesSite.theme.secondary_color})`;
            });
        }
        
        // Aplicar logo dinâmico
        if (configuracoesSite.theme.logo_url) {
            const logoImg = document.querySelector('.logo-img');
            if (logoImg) {
                logoImg.src = configuracoesSite.theme.logo_url;
                logoImg.style.display = 'block';
            }
        }
        
        // Aplicar modo escuro
        if (configuracoesSite.theme.enable_dark_mode) {
            document.body.classList.add('dark-mode');
        }
    }
}

// ✅ ATUALIZAR HORÁRIO DE FUNCIONAMENTO
// ✅ ATUALIZAR HORÁRIO DE FUNCIONAMENTO
function atualizarHorarioFuncionamento() {
    const horarioContainer = document.querySelector('.info-content');
    if (!horarioContainer || !configuracoesSite.business.horario_funcionamento) return;
    
    const horarios = configuracoesSite.business.horario_funcionamento.split('|');
    let html = '';
    
    horarios.forEach(horario_item => {
        const partes = horario_item.split(':', 2);
        if (partes.length === 2) {
            html += `
                <div class="info-item">
                    <span class="info-days">${partes[0].trim()}:</span>
                    <span class="info-hours">${partes[1].trim()}</span>
                </div>
            `;
        } else {
            html += `
                <div class="info-item">
                    <span class="info-days">${horario_item.trim()}</span>
                </div>
            `;
        }
    });
    
    horarioContainer.innerHTML = html;
}

// ✅ ATUALIZAR INFORMAÇÕES DE ENTREGA
function atualizarInformacoesEntrega() {
    const infoEntregaContainer = document.querySelector('.info-pagamento');
    if (!infoEntregaContainer) return;
    
    const taxaEntrega = configuracoesSite.business.taxa_entrega || 0;
    const infoTaxaEntrega = configuracoesSite.business.info_taxa_entrega || '';
    const valorFreteGratis = configuracoesSite.business.valor_frete_gratis || 0;
    const tempoEntrega = configuracoesSite.business.tempo_entrega || '';
    const deliveryEnabled = configuracoesSite.delivery.enable_delivery;
    
    let html = '';
    
    if (deliveryEnabled && taxaEntrega > 0) {
        html += `
            <div style="background: #f8f9fa; padding: 12px; border-radius: 8px; border-left: 4px solid #70a60f; margin-bottom: 10px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 600; color: #1a3311;">🚚 Taxa de Entrega:</span>
                    <span style="font-weight: 700; color: #70a60f;">
                        R$ ${taxaEntrega.toFixed(2).replace('.', ',')}
                    </span>
                </div>
                ${tempoEntrega ? `
                    <div style="font-size: 0.9rem; color: #666; margin-top: 5px;">
                        ⏱️ ${tempoEntrega}
                    </div>
                ` : ''}
                
                ${infoTaxaEntrega ? `
                    <div style="margin-top: 8px; padding: 8px; background: #e8f5e8; border-radius: 5px; border-left: 3px solid #28a745;">
                        <span style="font-size: 0.85rem; color: #1a3311;">
                            💡 ${infoTaxaEntrega}
                        </span>
                    </div>
                ` : ''}
            </div>
        `;
    }
    
    if (deliveryEnabled && valorFreteGratis > 0) {
        html += `
            <div style="background: #e8f5e8; padding: 12px; border-radius: 8px; border-left: 4px solid #28a745;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 600; color: #1a3311;">🎉 Frete Grátis:</span>
                    <span style="font-weight: 700; color: #28a745;">
                        Acima de R$ ${valorFreteGratis.toFixed(2).replace('.', ',')}
                    </span>
                </div>
            </div>
        `;
    }
    
    if (!deliveryEnabled) {
        html += `
            <div style="background: #fff3cd; padding: 12px; border-radius: 8px; border-left: 4px solid #ffc107;">
                <div style="display: flex; align-items: center; gap: 10px; color: #856404;">
                    <span>⚠️</span>
                    <span>Delivery temporariamente indisponível. Apenas retirada.</span>
                </div>
            </div>
        `;
    }
    
    const existingDeliveryInfo = infoEntregaContainer.querySelector('#delivery-info');
    if (existingDeliveryInfo) {
        existingDeliveryInfo.innerHTML = html;
    } else {
        infoEntregaContainer.innerHTML += `<div id="delivery-info">${html}</div>`;
    }
}

// ✅ ATUALIZAR RODAPÉ
function atualizarRodape() {
    const footer = document.querySelector('.footer');
    if (!footer) return;
    
    const telefone = configuracoesSite.site.telefone || '';
    const email = configuracoesSite.site.email || '';
    const whatsapp = configuracoesSite.social.whatsapp || '';
    const instagram = configuracoesSite.social.instagram || '';
    const endereco = configuracoesSite.site.endereco || '';
    
    let html = `
        <p>🌱 ${configuracoesSite.site.nome} - ${configuracoesSite.site.slogan}</p>
        <p>
    `;
    
    if (telefone) {
        html += `📞 ${telefone}`;
    }
    
    if (email) {
        html += `${telefone ? ' | ' : ''}✉️ ${email}`;
    }
    
    if (whatsapp) {
        html += `${telefone || email ? ' | ' : ''}
            <a href="https://wa.me/55${whatsapp.replace(/\D/g, '')}" 
               target="_blank" 
               style="color: white; text-decoration: underline;">
                💬 Fale no WhatsApp
            </a>
        `;
    }
    
    if (instagram) {
        html += `${telefone || email || whatsapp ? ' | ' : ''}
            <a href="${instagram}" 
               target="_blank" 
               style="color: white; text-decoration: underline;">
                📷 Siga no Instagram
            </a>
        `;
    }
    
    html += `</p>`;
    
    if (endereco) {
        html += `
            <p style="margin-top: 8px; font-size: 0.9rem; opacity: 0.9;">
                📍 ${endereco}
            </p>
        `;
    }
    
    footer.innerHTML = html;
}

// ✅ ATUALIZAR WHATSAPP FIXO
function atualizarWhatsApp() {
    const whatsappBtn = document.querySelector('.whatsapp-btn');
    const whatsappNumber = configuracoesSite.social.whatsapp;
    
    if (whatsappBtn && whatsappNumber) {
        const numeroLimpo = whatsappNumber.replace(/\D/g, '');
        whatsappBtn.href = `https://wa.me/55${numeroLimpo}?text=Olá! Gostaria de fazer um pedido.`;
        console.log('✅ WhatsApp atualizado:', numeroLimpo);
    }
}

// ✅ ATUALIZAR OPÇÕES DE PAGAMENTO NO MODAL
function atualizarOpcoesPagamento() {
    // Esta função será usada quando o modal de finalização for aberto
    console.log('💳 Configurações de pagamento carregadas:', configuracoesSite.payment);
}

// ✅ FUNÇÃO PARA OBTER CONFIGURAÇÕES (para uso em outras partes do código)
function getConfig(key, defaultValue = null) {
    const keys = key.split('.');
    let value = configuracoesSite;
    
    for (const k of keys) {
        if (value && typeof value === 'object' && k in value) {
            value = value[k];
        } else {
            return defaultValue;
        }
    }
    
    return value;
}
// ✅ ATUALIZAR OPÇÕES DE PAGAMENTO NO MODAL
function atualizarOpcoesPagamentoModal() {
    const selectPagamento = document.getElementById('selectFormaPagamento');
    if (!selectPagamento) {
        console.log('❌ Select de pagamento não encontrado');
        return;
    }
    
    // Limpar opções exceto a primeira
    while (selectPagamento.children.length > 1) {
        selectPagamento.removeChild(selectPagamento.lastChild);
    }
    
    console.log('💳 Atualizando opções de pagamento:', configuracoesSite.payment);
    
    // Adicionar opções baseadas nas configurações
    if (configuracoesSite.payment.aceita_pix) {
        const option = document.createElement('option');
        option.value = 'PIX';
        option.textContent = '💠 PIX';
        selectPagamento.appendChild(option);
    }
    
    if (configuracoesSite.payment.aceita_cartao) {
        const optionCredito = document.createElement('option');
        optionCredito.value = 'Cartão Crédito';
        optionCredito.textContent = '💳 Link Cartão de Crédito';
        selectPagamento.appendChild(optionCredito);
        
        const optionDebito = document.createElement('option');
        optionDebito.value = 'Cartão Débito';
        optionDebito.textContent = '💳 Link Cartão de Débito';
        selectPagamento.appendChild(optionDebito);
    }
    
    if (configuracoesSite.payment.aceita_dinheiro) {
        const option = document.createElement('option');
        option.value = 'Dinheiro';
        option.textContent = '💵 Dinheiro';
        selectPagamento.appendChild(option);
    }
    
    // Se nenhuma opção foi adicionada, mostrar aviso
    if (selectPagamento.children.length === 1) {
        const option = document.createElement('option');
        option.value = '';
        option.textContent = '⚠️ Nenhuma forma de pagamento configurada';
        option.disabled = true;
        selectPagamento.appendChild(option);
    }
}

// ✅ ATUALIZAR WHATSAPP FIXO
function atualizarWhatsApp() {
    const whatsappBtn = document.querySelector('.whatsapp-btn');
    const whatsappNumber = configuracoesSite.social.whatsapp;
    
    if (whatsappBtn && whatsappNumber) {
        const numeroLimpo = whatsappNumber.replace(/\D/g, '');
        whatsappBtn.href = `https://wa.me/55${numeroLimpo}?text=Olá! Gostaria de fazer um pedido.`;
        console.log('✅ WhatsApp atualizado:', numeroLimpo);
    } else {
        console.log('❌ WhatsApp não configurado ou botão não encontrado');
    }
}

// ✅ ATUALIZAR A INICIALIZAÇÃO
document.addEventListener('DOMContentLoaded', async function() {
    console.log('🚀 Iniciando sistema Ouro Verde Orgânicos...');
    
    // ✅ CARREGAR CONFIGURAÇÕES PRIMEIRO
    await carregarConfiguracoes();
    
    inicializarCarrossel();
    
    // ✅ CARREGAR FORMAS DE VENDA
    await carregarFormasVenda();
    
    // ✅ DEPOIS CARREGAR PRODUTOS
    await carregarProdutos();
    
    setTimeout(() => {
        inicializarGestosCategorias();
    }, 1500);
    
    reiniciarAutoPlay();
    
    document.addEventListener('click', function(e) {
        if (e.target.matches('button:not(:disabled)')) {
            e.target.style.transform = 'scale(0.98)';
            setTimeout(() => {
                e.target.style.transform = '';
            }, 150);
        }
    });
});

        // ========== EVENTOS GLOBAIS ==========
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }

        // ========== EXPORTAÇÃO PARA ESCOPO GLOBAL ==========
        window.editarItemCarrinho = editarItemCarrinho;
        window.atualizarItemCarrinho = atualizarItemCarrinho;
        window.moverCarrossel = moverCarrossel;
        window.filtrarCategoria = filtrarCategoria;
        window.abrirModalCompra = abrirModalCompra;
        window.fecharModalCompra = fecharModalCompra;
        window.selecionarFormaVenda = selecionarFormaVenda;
        window.adicionarAoCarrinho = adicionarAoCarrinho;
        window.removerItemCarrinho = removerItemCarrinho;
        window.toggleCarrinho = toggleCarrinho;
        window.abrirModalFinalizar = abrirModalFinalizar;
        window.fecharModalFinalizar = fecharModalFinalizar;
        window.formatarCEP = formatarCEP;
        window.enviarPedido = enviarPedido;
        window.escapeHtml = escapeHtml;
        window.navegarCategorias = navegarCategorias;
        window.selecionarTipoEntrega = selecionarTipoEntrega;

        // ✅ BUSCA DE CEP COM DEBOUNCE
        const buscarEnderecoDebounced = debounce(async function(cep) {
            const cepLimpo = cep.replace(/\D/g, '');
            const enderecoInput = document.querySelector('input[name="endereco"]');
            const numeroInput = document.querySelector('input[name="numero"]');
            const complementoInput = document.querySelector('input[name="complemento"]');
            
            if (cepLimpo.length !== 8) {
                enderecoInput.value = '';
                enderecoInput.readOnly = false;
                mostrarToast('❌ CEP deve ter 8 dígitos. Ex: 64000-000', 'erro');
                return;
            }
            
            console.log('🔍 Buscando CEP:', cepLimpo);
            enderecoInput.value = 'Buscando endereço...';
            enderecoInput.readOnly = true;
            if (numeroInput) numeroInput.disabled = true;
            if (complementoInput) complementoInput.disabled = true;
            
            try {
                const response = await fetch(`https://viacep.com.br/ws/${cepLimpo}/json/`);
                
                if (!response.ok) throw new Error('Erro na resposta da API');
                
                const data = await response.json();
                console.log('📦 Dados do CEP:', data);
                
                if (data.erro) {
                    enderecoInput.value = '';
                    enderecoInput.readOnly = false;
                    if (numeroInput) numeroInput.disabled = false;
                    if (complementoInput) complementoInput.disabled = false;
                    mostrarToast('❌ CEP não encontrado. Digite o endereço manualmente.', 'erro');
                    return;
                }
                
                enderecoInput.value = data.logradouro || '';
                enderecoInput.readOnly = false;
                
                if (numeroInput) numeroInput.disabled = false;
                if (complementoInput) complementoInput.disabled = false;
                
                if (numeroInput) numeroInput.focus();
                
            } catch (error) {
                console.error('❌ Erro ao buscar CEP:', error);
                enderecoInput.value = '';
                enderecoInput.readOnly = false;
                if (numeroInput) numeroInput.disabled = false;
                if (complementoInput) complementoInput.disabled = false;
                mostrarToast('❌ Erro ao buscar CEP. Verifique sua conexão.', 'erro');
            }
        }, CONFIG.DEBOUNCE_DELAY);
    </script>
</body>
</html>