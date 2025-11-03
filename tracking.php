<?php
require_once 'config/site_settings.php';
session_start();

// Verificar se há um pedido na sessão ou parâmetro URL
$pedido_id = $_SESSION['ultimo_pedido_id'] ?? $_GET['pedido_id'] ?? null;
$cliente_email = $_SESSION['cliente_email'] ?? $_GET['email'] ?? null;

// Se não tem pedido na sessão, verificar se tem nos parâmetros
if (!$pedido_id && isset($_GET['pedido_id'])) {
    $_SESSION['ultimo_pedido_id'] = $_GET['pedido_id'];
    $pedido_id = $_GET['pedido_id'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acompanhar Pedido - <?php echo SiteSettings::getSiteName(); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            color: #333;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #70a60f, #5a850c);
            color: white;
            padding: 30px 20px;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 0 0 20px 20px;
        }

        .header .logo-img {
            max-height: 80px;
            margin-bottom: 15px;
        }

        .tracking-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .status-timeline {
            position: relative;
            padding: 20px 0;
        }

        .status-line {
            position: absolute;
            top: 5px;
            left: 30px;
            width: calc(100% - 60px);
            height: 3px;
            background: #e0e0e0;
            z-index: 1;
        }

        .status-progress {
            position: absolute;
            top: 5px;
            left: 30px;
            height: 3px;
            background: #70a60f;
            z-index: 2;
            transition: width 0.5s ease;
        }

        .status-item {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 3;
        }

        .status-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: white;
            border: 3px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 20px;
            transition: all 0.3s ease;
        }

        .status-item.active .status-icon {
            background: #70a60f;
            border-color: #70a60f;
            color: white;
            transform: scale(1.1);
        }

        .status-item.completed .status-icon {
            background: #28a745;
            border-color: #28a745;
            color: white;
        }

        .status-content {
            flex: 1;
        }

        .status-title {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .status-description {
            color: #666;
            font-size: 0.9rem;
        }

        .status-time {
            color: #888;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .pedido-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: 600;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .info-value {
            font-weight: 600;
            color: #333;
        }

        .btn-voltar {
            display: inline-block;
            background: #70a60f;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-voltar:hover {
            background: #5a850c;
            transform: translateY(-2px);
        }

        .whatsapp-fixed {
            position: fixed;
            bottom: 20px;
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

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .erro {
            text-align: center;
            padding: 40px;
            color: #dc3545;
            background: #f8d7da;
            border-radius: 10px;
            margin: 20px 0;
        }

        .buscar-pedido {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            text-align: center;
        }

        .form-buscar {
            max-width: 400px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
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

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .tracking-card {
                padding: 20px;
            }
            
            .status-icon {
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
            }
            
            .whatsapp-btn {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
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
        <h1>Acompanhar Pedido</h1>
        <p>Acompanhe o status do seu pedido em tempo real</p>
    </div>

    <div class="container">
        <?php if (!$pedido_id): ?>
            <!-- Formulário para buscar pedido -->
            <div class="buscar-pedido">
                <h2 style="margin-bottom: 20px; color: #1a3311;">🔍 Buscar Pedido</h2>
                <p style="margin-bottom: 25px; color: #666;">
                    Digite o número do seu pedido e e-mail para acompanhar o status
                </p>
                
                <form class="form-buscar" onsubmit="buscarPedido(event)">
                    <div class="form-group">
                        <label class="form-label">Número do Pedido *</label>
                        <input type="text" class="form-control" name="pedido_id" required 
                               placeholder="Ex: 123">
                    </div>
                    <div class="form-group">
                        <label class="form-label">E-mail *</label>
                        <input type="email" class="form-control" name="email" required 
                               placeholder="seu@email.com">
                    </div>
                    <button type="submit" class="btn-voltar" style="width: 100%;">
                        🔍 Buscar Pedido
                    </button>
                </form>
            </div>
            
            <div style="text-align: center;">
                <a href="index.php" class="btn-voltar">🛒 Voltar para Loja</a>
            </div>
            
        <?php else: ?>
            <div id="tracking-container">
                <div class="loading">
                    <div>🔄 Carregando informações do pedido...</div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Botão WhatsApp Fixo -->
    <div class="whatsapp-fixed">
        <a href="https://wa.me/55<?php echo preg_replace('/[^0-9]/', '', SiteSettings::getWhatsapp()); ?>?text=Olá! Gostaria de acompanhar meu pedido." 
           class="whatsapp-btn" 
           target="_blank">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

    <script>
        const PEDIDO_ID = <?php echo $pedido_id ?: 'null'; ?>;
        const CLIENTE_EMAIL = '<?php echo $cliente_email ?: ''; ?>';

        function buscarPedido(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const pedidoId = formData.get('pedido_id');
            const email = formData.get('email');
            
            // Redirecionar para a mesma página com os parâmetros
            window.location.href = `tracking.php?pedido_id=${pedidoId}&email=${encodeURIComponent(email)}`;
        }

        async function carregarStatusPedido() {
            if (!PEDIDO_ID) return;

            try {
                const response = await fetch(`backend/api/pedidos.php?action=tracking&pedido_id=${PEDIDO_ID}&email=${CLIENTE_EMAIL}`);
                const data = await response.json();

                if (data.success) {
                    renderizarStatus(data.pedido);
                    iniciarAtualizacaoAutomatica();
                } else {
                    mostrarErro(data.message || 'Pedido não encontrado');
                }
            } catch (error) {
                console.error('Erro ao carregar pedido:', error);
                mostrarErro('Erro ao carregar informações do pedido');
            }
        }

function renderizarStatus(pedido) {
    const statusMap = {
        'pendente': { 
            etapa: 1, 
            icone: '⏳', 
            titulo: 'Pedido Recebido',
            descricao: 'Seu pedido foi recebido e está sendo processado'
        },
        'confirmado': { 
            etapa: 2, 
            icone: '✅', 
            titulo: 'Pedido Confirmado',
            descricao: 'Seu pedido foi confirmado'
        },
        'concluido': { 
            etapa: 3, 
            icone: '🚚', 
            titulo: 'Saiu para Entrega',
            descricao: 'Seu pedido saiu para entrega'
        },
        'cancelado': { 
            etapa: 0, 
            icone: '❌', 
            titulo: 'Pedido Cancelado',
            descricao: 'Este pedido foi cancelado'
        }
    };

    const etapas = [
        { id: 'pendente', ...statusMap.pendente },
        { id: 'confirmado', ...statusMap.confirmado },
        { id: 'concluido', ...statusMap.concluido }
    ];

    // Remover etapas se pedido cancelado
    if (pedido.status === 'cancelado') {
        etapas.length = 0;
        etapas.push({ id: 'cancelado', ...statusMap.cancelado });
    }

    const etapaAtual = statusMap[pedido.status]?.etapa || 1;
    const progresso = etapas.length > 1 ? ((etapaAtual - 1) / (etapas.length - 1)) * 100 : 0;

    let html = `
        <div class="tracking-card">
            <h2 style="margin-bottom: 20px; color: #1a3311;">📦 Pedido #${pedido.id}</h2>
            
            <div class="pedido-info">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Data do Pedido</span>
                        <span class="info-value">${formatarData(pedido.data_criacao)}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status Atual</span>
                        <span class="info-value" style="color: ${getCorStatus(pedido.status)}; font-weight: bold;">
                            ${statusMap[pedido.status]?.titulo || 'Pendente'}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Total</span>
                        <span class="info-value">R$ ${parseFloat(pedido.total).toFixed(2)}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Forma de Pagamento</span>
                        <span class="info-value">${pedido.forma_pagamento}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Cliente</span>
                        <span class="info-value">${pedido.cliente.nome}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Telefone</span>
                        <span class="info-value">${pedido.cliente.telefone}</span>
                    </div>
                </div>
                
                ${pedido.observacoes ? `
                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                        <div class="info-label">Observações</div>
                        <div class="info-value">${pedido.observacoes}</div>
                    </div>
                ` : ''}
            </div>

            ${pedido.status !== 'cancelado' ? `
            <div class="status-timeline">
                <div class="status-line"></div>
                <div class="status-progress" style="width: ${progresso}%"></div>
                
                ${etapas.map((etapa, index) => {
                    const isActive = etapa.id === pedido.status;
                    const isCompleted = index < etapaAtual - 1;
                    const classe = isActive ? 'active' : isCompleted ? 'completed' : '';
                    
                    return `
                        <div class="status-item ${classe}">
                            <div class="status-icon">
                                ${etapa.icone}
                            </div>
                            <div class="status-content">
                                <div class="status-title">${etapa.titulo}</div>
                                <div class="status-description">${etapa.descricao}</div>
                                ${isActive && pedido.ultima_atualizacao ? `
                                    <div class="status-time">
                                        📅 ${formatarData(pedido.ultima_atualizacao)}
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                }).join('')}
            </div>
            ` : `
            <div style="text-align: center; padding: 40px 20px;">
                <div class="status-icon" style="background: #dc3545; border-color: #dc3545; margin: 0 auto 20px;">
                    ❌
                </div>
                <h3 style="color: #dc3545; margin-bottom: 10px;">Pedido Cancelado</h3>
                <p style="color: #666;">Este pedido foi cancelado. Entre em contato para mais informações.</p>
            </div>
            `}

            <div style="text-align: center; margin-top: 30px;">
                <a href="index.php" class="btn-voltar">🛒 Continuar Comprando</a>
                <button onclick="buscarOutroPedido()" class="btn-voltar" style="background: #6c757d; margin-left: 10px;">
                    🔍 Buscar Outro Pedido
                </button>
            </div>
        </div>

        <!-- Seção WhatsApp para Acompanhamento -->
        <div class="tracking-card">
            <h3 style="margin-bottom: 15px; color: #1a3311;">💬 Acompanhamento via WhatsApp</h3>
            <p style="margin-bottom: 20px; color: #666;">
                Fique por dentro das atualizações do seu pedido diretamente pelo WhatsApp!
            </p>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: center;">
                <a href="https://wa.me/55<?php echo preg_replace('/[^0-9]/', '', SiteSettings::getWhatsapp()); ?>?text=Olá! Gostaria de acompanhar o pedido #${pedido.id}" 
                   class="btn-voltar" 
                   target="_blank"
                   style="background: #25D366;">
                    <i class="fab fa-whatsapp"></i> Acompanhar Pedido
                </a>
                <a href="https://wa.me/55<?php echo preg_replace('/[^0-9]/', '', SiteSettings::getWhatsapp()); ?>?text=Olá! Tenho uma dúvida sobre meu pedido #${pedido.id}" 
                   class="btn-voltar" 
                   target="_blank"
                   style="background: #17a2b8;">
                    <i class="fas fa-question-circle"></i> Tirar Dúvidas
                </a>
            </div>
        </div>
    `;

    document.getElementById('tracking-container').innerHTML = html;
}

        function formatarData(dataString) {
            if (!dataString) return '-';
            const data = new Date(dataString);
            return data.toLocaleString('pt-BR');
        }

function getCorStatus(status) {
    const cores = {
        'pendente': '#ffc107',
        'confirmado': '#17a2b8',
        'concluido': '#70a60f',
        'cancelado': '#dc3545'
    };
    return cores[status] || '#6c757d';
}

        function mostrarErro(mensagem) {
            document.getElementById('tracking-container').innerHTML = `
                <div class="erro">
                    <h2>❌ ${mensagem}</h2>
                    <button onclick="buscarOutroPedido()" class="btn-voltar" style="margin-top: 15px;">
                        🔍 Tentar Novamente
                    </button>
                </div>
            `;
        }

        function buscarOutroPedido() {
            // Limpar sessão e recarregar
            window.location.href = 'tracking.php';
        }

        function iniciarAtualizacaoAutomatica() {
            // Atualizar a cada 30 segundos
            setInterval(carregarStatusPedido, 30000);
        }

        // Iniciar quando a página carregar
        if (PEDIDO_ID) {
            carregarStatusPedido();
        }
    </script>
</body>
</html>