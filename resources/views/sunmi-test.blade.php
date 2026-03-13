<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUNMI Printer Web Bridge Test</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #FF5F1F;
            --primary-dark: #cc4c18;
            --bg-dark: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
            --success: #10b981;
            --error: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(255, 95, 31, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(30, 64, 175, 0.15) 0%, transparent 50%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem;
        }

        .container {
            width: 100%;
            max-width: 600px;
        }

        header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #fff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            color: var(--text-dim);
            font-size: 1rem;
        }

        .status-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .status-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--text-dim);
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }

        .status-dot.connected {
            background: var(--success);
            box-shadow: 0 0 15px var(--success);
            animation: pulse 2s infinite;
        }

        .status-dot.error {
            background: var(--error);
            box-shadow: 0 0 15px var(--error);
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }

        .actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        button {
            padding: 1rem;
            border-radius: 1rem;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        button:active {
            transform: scale(0.95);
        }

        button.primary {
            background: var(--primary);
            border-color: var(--primary);
            grid-column: span 2;
        }

        button.primary:hover {
            background: var(--primary-dark);
            box-shadow: 0 4px 20px rgba(255, 95, 31, 0.4);
        }

        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .logs {
            background: #000;
            border-radius: 1rem;
            padding: 1rem;
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.85rem;
            height: 200px;
            overflow-y: auto;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .log-entry {
            margin-bottom: 0.25rem;
            color: #10b981;
        }

        .log-entry.error {
            color: #ef4444;
        }

        .log-entry.timestamp {
            color: #64748b;
            margin-right: 0.5rem;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>SUNMI V3 Control</h1>
            <p class="subtitle">Web Bridge Diagnostics & Printing</p>
        </header>

        <div class="status-card">
            <div class="status-info">
                <div id="statusDot" class="status-dot"></div>
                <div>
                    <div style="font-weight: 600;">Bridge Status</div>
                    <div id="statusText" class="subtitle" style="font-size: 0.8rem;">Detecting...</div>
                </div>
            </div>
            <button id="refreshBtn" style="padding: 0.5rem 1rem;">Refresh</button>
        </div>

        <div class="actions">
            <button id="initBtn" class="primary" disabled>
                Initialize Printer
            </button>
            <button id="printTextBtn" disabled>
                Print Sample Text
            </button>
            <button id="printQrBtn" disabled>
                Print Sample QR
            </button>
        </div>

        <div id="logArea" class="logs">
            <div class="log-entry">System ready. Waiting for detection...</div>
        </div>
    </div>

    <script>
        const statusDot = document.getElementById('statusDot');
        const statusText = document.getElementById('statusText');
        const initBtn = document.getElementById('initBtn');
        const printTextBtn = document.getElementById('printTextBtn');
        const printQrBtn = document.getElementById('printQrBtn');
        const logArea = document.getElementById('logArea');
        const refreshBtn = document.getElementById('refreshBtn');

        function addLog(message, type = 'info') {
            const entry = document.createElement('div');
            entry.className = `log-entry ${type}`;
            const time = new Date().toLocaleTimeString();
            entry.innerHTML = `<span class="timestamp">[${time}]</span> ${message}`;
            logArea.appendChild(entry);
            logArea.scrollTop = logArea.scrollHeight;
        }

        function checkBridge() {
            const isSunmi = !!(window.sunmi && window.sunmi.innerPrinter);
            
            if (isSunmi) {
                statusDot.className = 'status-dot connected';
                statusText.innerText = 'SUNMI Bridge Connected';
                addLog('SUNMI Web Bridge detected successfully!');
                
                initBtn.disabled = false;
                printTextBtn.disabled = false;
                printQrBtn.disabled = false;
            } else {
                statusDot.className = 'status-dot error';
                statusText.innerText = 'Bridge Not Found';
                addLog('Bridge not found. Are you using the SUNMI Browser?', 'error');
                
                initBtn.disabled = true;
                printTextBtn.disabled = true;
                printQrBtn.disabled = true;
            }
        }

        refreshBtn.onclick = () => {
            addLog('Re-scanning for bridge...');
            checkBridge();
        };

        initBtn.onclick = () => {
            try {
                window.sunmi.innerPrinter.printerInit();
                addLog('Printer initialized.');
            } catch (e) {
                addLog('Init failed: ' + e.message, 'error');
            }
        };

        printTextBtn.onclick = () => {
            try {
                const printer = window.sunmi.innerPrinter;
                printer.printerInit();
                printer.setAlignment(1);
                printer.printText("SUNMI V3 WEB TEST\n");
                printer.printText("--------------------------------\n");
                printer.setAlignment(0);
                printer.printText("Web printing is working!\n");
                printer.lineWrap(3);
                addLog('Print command sent (Sample Text).');
            } catch (e) {
                addLog('Print failed: ' + e.message, 'error');
            }
        };

        printQrBtn.onclick = () => {
            try {
                const printer = window.sunmi.innerPrinter;
                printer.printerInit();
                printer.setAlignment(1);
                printer.printText("TEST QR CODE\n\n");
                printer.printQrCode("https://google.com", 6, 2);
                printer.lineWrap(4);
                addLog('Print command sent (QR Code).');
            } catch (e) {
                addLog('Print failed: ' + e.message, 'error');
            }
        };

        // Initial check
        setTimeout(checkBridge, 1000);
    </script>
</body>
</html>
