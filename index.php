<?php
require_once 'functions.php';

$m = '';
$sl = '';
$us = get_data();

if (!empty($_GET['u'])) {
    $c = $_GET['u'];
    $o = get_url($c);
    if ($o) {
        click($c);
        header("Location: " . $o);
        exit;
    } else {
        $m = "Invalid link.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['url'])) {
    $u = trim($_POST['url']);
    if (!preg_match("~^(?:f|ht)tps?://~i", $u)) {
        $u = "http://" . $u;
    }
    
    $u = filter_var($u, FILTER_SANITIZE_URL);
    if (filter_var($u, FILTER_VALIDATE_URL)) {
        $c = shorten($u);
        $p = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $h = $_SERVER['HTTP_HOST'];
        $s = dirname($_SERVER['SCRIPT_NAME']);
        if ($s === '/' || $s === '\\') $s = '';
        $sl = "$p://$h$s/?u=$c";
        $us = get_data();
    } else {
        $m = "Invalid URL.";
    }
}

$p = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$h = $_SERVER['HTTP_HOST'];
$s = dirname($_SERVER['SCRIPT_NAME']);
if ($s === '/' || $s === '\\') $s = '';
$b = "$p://$h$s/";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="w">
        <div class="h">
            <div class="c">
                <h1>Shorten Links</h1>
                <p class="st">Shorten your links and generate QR codes for them </p>
                
                <form method="POST" action="" class="f">
                    <div class="g">
                        <input type="url" name="url" placeholder="Enter URL" required>
                        <button type="submit">Shorten</button>
                    </div>
                </form>

                <?php if ($sl): ?>
                    <div class="r">
                        <p>Ready:</p>
                        <div class="lb">
                            <a href="<?php echo $sl; ?>" target="_blank" class="l"><?php echo $sl; ?></a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($m): ?>
                    <div class="e">
                        <?php echo $m; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="d">
            <div class="c">
      
                <div class="tc">
                    <div class="tr">
                        <table>
                            <thead>
                                <tr>
                                    <th>Link</th>
                                    <th>Original</th>
                                    <th>Clicks</th>
                                    <th>QR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($us)): ?>
                                    <tr><td colspan="4" class="n">No links.</td></tr>
                                <?php else: ?>
                                    <?php foreach (array_reverse($us) as $c => $d): ?>
                                        <?php 
                                            $su = $b . "?u=" . $c;
                                            $ou = is_array($d) ? $d['url'] : $d;
                                            $cl = is_array($d) ? ($d['clicks'] ?? 0) : 0;
                                        ?>
                                        <tr>
                                            <td><a href="<?php echo $su; ?>" target="_blank" class="lt"><?php echo $c; ?></a></td>
                                            <td class="oc" title="<?php echo htmlspecialchars($ou); ?>"><?php echo htmlspecialchars($ou); ?></td>
                                            <td class="cc"><span class="bg"><?php echo $cl; ?></span></td>
                                            <td><img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=<?php echo urlencode($su); ?>" alt="QR" class="qr"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
