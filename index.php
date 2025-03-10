<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/functions.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['API_KEY'];

$userIP = getRealIpAddr();
$userIP = '8.8.8.8';

$ipData = getIPData($userIP, $apiKey);
$hasError = isset($ipData['error']) || isset($ipData['message']);

?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo translate('IP Details Lookup', $translations); ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.3/leaflet.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="Stylesheet" href="site.css" />
</head>
<body>
    <div class="container py-4">
        <h1 class="text-center title mb-5">
            <i class="fas fa-globe-asia"></i> <?php echo translate('IP Details Lookup', $translations); ?>
        </h1>
        
        <?php if ($hasError): ?>
            <div class="alert alert-danger">
                <?php 
                    $errorMsg = isset($ipData['message']) ? $ipData['message'] : $ipData['error'];
                    if (strpos($errorMsg, 'API request failed') === 0) {
                        $errorMsg = translate('API request failed', $translations) . ': ' . substr($errorMsg, 18);
                    }
                    echo $errorMsg;
                ?>
            </div>
            <div class="alert alert-warning">
                <strong><?php echo translate('Note', $translations); ?>:</strong> 
                <?php echo translate('Make sure to replace the placeholder API key with your actual IPData API key in the PHP code.', $translations); ?>
            </div>
        <?php else: ?>
            <div class="text-center mb-5">
                <span class="badge ip-badge">
                    <i class="fas fa-network-wired me-2"></i>
                    <?php echo translate('Your IP', $translations); ?>: <?php echo htmlspecialchars($userIP); ?>
                </span>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-map-marker-alt"></i> <?php echo translate('Location Information', $translations); ?>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><div class="info-icon"><i class="fas fa-flag"></i></div><?php echo translate('Country', $translations); ?>:</span>
                                    <span class="fw-bold">
                                        <?php if (isset($ipData['country_name'])): ?>
                                            <?php if (isset($ipData['flag'])): ?>
                                                <img src="<?php echo htmlspecialchars($ipData['flag']); ?>" alt="Flag" class="flag-img">
                                            <?php endif; ?>
                                            <?php echo htmlspecialchars($ipData['country_name']); ?>
                                        <?php else: ?>
                                            <?php echo translate('N/A', $translations); ?>
                                        <?php endif; ?>
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><div class="info-icon"><i class="fas fa-map"></i></div><?php echo translate('Region', $translations); ?>:</span>
                                    <span class="fw-bold"><?php echo isset($ipData['region']) ? htmlspecialchars($ipData['region']) : translate('N/A', $translations); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><div class="info-icon"><i class="fas fa-city"></i></div><?php echo translate('City', $translations); ?>:</span>
                                    <span class="fw-bold"><?php echo isset($ipData['city']) ? htmlspecialchars($ipData['city']) : translate('N/A', $translations); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><div class="info-icon"><i class="fas fa-mailbox"></i></div><?php echo translate('Postal Code', $translations); ?>:</span>
                                    <span class="fw-bold"><?php echo isset($ipData['postal']) ? htmlspecialchars($ipData['postal']) : translate('N/A', $translations); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><div class="info-icon"><i class="fas fa-location-arrow"></i></div><?php echo translate('Coordinates', $translations); ?>:</span>
                                    <span class="fw-bold">
                                        <?php 
                                        if (isset($ipData['latitude']) && isset($ipData['longitude'])) {
                                            echo htmlspecialchars($ipData['latitude'] . ', ' . $ipData['longitude']);
                                        } else {
                                            echo translate('N/A', $translations);
                                        }
                                        ?>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-server"></i> <?php echo translate('Network Information', $translations); ?>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><div class="info-icon"><i class="fas fa-wifi"></i></div><?php echo translate('ISP', $translations); ?>:</span>
                                    <span class="fw-bold"><?php echo isset($ipData['asn']['name']) ? htmlspecialchars($ipData['asn']['name']) : translate('N/A', $translations); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><div class="info-icon"><i class="fas fa-network-wired"></i></div><?php echo translate('ASN', $translations); ?>:</span>
                                    <span class="fw-bold"><?php echo isset($ipData['asn']['asn']) ? 'AS' . htmlspecialchars($ipData['asn']['asn']) : translate('N/A', $translations); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><div class="info-icon"><i class="fas fa-building"></i></div><?php echo translate('Organization', $translations); ?>:</span>
                                    <span class="fw-bold"><?php echo isset($ipData['organisation']) ? htmlspecialchars($ipData['organisation']) : translate('N/A', $translations); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><div class="info-icon"><i class="fas fa-clock"></i></div><?php echo translate('Time Zone', $translations); ?>:</span>
                                    <span class="fw-bold"><?php echo isset($ipData['time_zone']['name']) ? htmlspecialchars($ipData['time_zone']['name']) : translate('N/A', $translations); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><div class="info-icon"><i class="fas fa-money-bill-alt"></i></div><?php echo translate('Currency', $translations); ?>:</span>
                                    <span class="fw-bold">
                                        <?php 
                                        if (isset($ipData['currency']['name']) && isset($ipData['currency']['code'])) {
                                            echo htmlspecialchars($ipData['currency']['name'] . ' (' . $ipData['currency']['code'] . ')');
                                        } else {
                                            echo translate('N/A', $translations);
                                        }
                                        ?>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if (isset($ipData['latitude']) && isset($ipData['longitude'])): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-map"></i> <?php echo translate('Map Location', $translations); ?>
                    </div>
                    <div class="card-body">
                        <div id="map" class="map-container"></div>
                    </div>
                </div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.3/leaflet.min.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const lat = <?php echo $ipData['latitude']; ?>;
                        const lng = <?php echo $ipData['longitude']; ?>;
                        const map = L.map('map').setView([lat, lng], 10);
                        
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);
                        
                        const marker = L.marker([lat, lng]).addTo(map);
                        
                        const popupContent = `
                            <div style="text-align: center; font-family: 'Vazirmatn', sans-serif;">
                                <strong><?php echo translate('Your Location', $translations); ?></strong><br>
                                <?php echo isset($ipData['city']) ? htmlspecialchars($ipData['city']) . ', ' : ''; ?>
                                <?php echo isset($ipData['country_name']) ? htmlspecialchars($ipData['country_name']) : ''; ?>
                            </div>
                        `;
                        
                        marker.bindPopup(popupContent).openPopup();
                        L.circle([lat, lng], {
                            color: '#4e54c8',
                            fillColor: '#8f94fb',
                            fillOpacity: 0.2,
                            radius: 10000
                        }).addTo(map);
                    });
                </script>
            <?php endif; ?>
            
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> <?php echo translate('Additional Information', $translations); ?>
                </div>
                <div class="card-body">
                    <div class="accordion" id="additionalInfo">
                        <?php if (isset($ipData['threat'])): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#threatInfo">
                                    <i class="fas fa-shield-alt me-2"></i> <?php echo translate('Threat Information', $translations); ?>
                                </button>
                            </h2>
                            <div id="threatInfo" class="accordion-collapse collapse" data-bs-parent="#additionalInfo">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><div class="info-icon"><i class="fas fa-mask"></i></div><?php echo translate('Is Tor', $translations); ?>:</span>
                                            <span class="fw-bold">
                                                <?php 
                                                if (isset($ipData['threat']['is_tor'])) {
                                                    echo $ipData['threat']['is_tor'] ? 
                                                        '<span class="badge bg-danger">' . translate('Yes', $translations) . '</span>' : 
                                                        '<span class="badge bg-success">' . translate('No', $translations) . '</span>';
                                                } else {
                                                    echo translate('N/A', $translations);
                                                }
                                                ?>
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><div class="info-icon"><i class="fas fa-random"></i></div><?php echo translate('Is Proxy', $translations); ?>:</span>
                                            <span class="fw-bold">
                                                <?php 
                                                if (isset($ipData['threat']['is_proxy'])) {
                                                    echo $ipData['threat']['is_proxy'] ? 
                                                        '<span class="badge bg-danger">' . translate('Yes', $translations) . '</span>' : 
                                                        '<span class="badge bg-success">' . translate('No', $translations) . '</span>';
                                                } else {
                                                    echo translate('N/A', $translations);
                                                }
                                                ?>
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><div class="info-icon"><i class="fas fa-user-secret"></i></div><?php echo translate('Is Anonymous', $translations); ?>:</span>
                                            <span class="fw-bold">
                                                <?php 
                                                if (isset($ipData['threat']['is_anonymous'])) {
                                                    echo $ipData['threat']['is_anonymous'] ? 
                                                        '<span class="badge bg-danger">' . translate('Yes', $translations) . '</span>' : 
                                                        '<span class="badge bg-success">' . translate('No', $translations) . '</span>';
                                                } else {
                                                    echo translate('N/A', $translations);
                                                }
                                                ?>
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><div class="info-icon"><i class="fas fa-user-ninja"></i></div><?php echo translate('Is Known Attacker', $translations); ?>:</span>
                                            <span class="fw-bold">
                                                <?php 
                                                if (isset($ipData['threat']['is_known_attacker'])) {
                                                    echo $ipData['threat']['is_known_attacker'] ? 
                                                        '<span class="badge bg-danger">' . translate('Yes', $translations) . '</span>' : 
                                                        '<span class="badge bg-success">' . translate('No', $translations) . '</span>';
                                                } else {
                                                    echo translate('N/A', $translations);
                                                }
                                                ?>
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><div class="info-icon"><i class="fas fa-user-slash"></i></div><?php echo translate('Is Known Abuser', $translations); ?>:</span>
                                            <span class="fw-bold">
                                                <?php 
                                                if (isset($ipData['threat']['is_known_abuser'])) {
                                                    echo $ipData['threat']['is_known_abuser'] ? 
                                                        '<span class="badge bg-danger">' . translate('Yes', $translations) . '</span>' : 
                                                        '<span class="badge bg-success">' . translate('No', $translations) . '</span>';
                                                } else {
                                                    echo translate('N/A', $translations);
                                                }
                                                ?>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="card mt-4 text-start">
        <div class="card-header">
                <i class="fas fa-calculator"></i> محاسبه گر آیپی
            </div>
            <div class="card-body">
                <form id="ipCalcForm">
                    <div class="mb-3">
                        <label for="ipAddress" class="form-label">آیپی:</label>
                        <input type="text" class="form-control" id="ipAddress" placeholder="مثال: 192.168.1.1">
                    </div>
                    <div class="mb-3">
                        <label for="subnet" class="form-label">subnet یا زیر شبکه (Mask or CIDR):</label>
                        <input type="text" class="form-control" id="subnet" placeholder="مثال: 255.255.255.0 یا /24">
                    </div>
                    <button type="button" class="btn btn-primary" onclick="calculateIP()">محاسبه</button>
                </form>
                
                <div id="ipCalcResult" class="mt-3"></div>
            </div>
        </div>


        
        <div class="footer mt-4">
            <p>© <?php echo date('Y'); ?> - ابزار بررسی اطلاعات آی‌پی </p>
            <p><a href="https://mousavi.dev">Mousavi.dev</a></p>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="./site.js"></script>
</body>
</html>