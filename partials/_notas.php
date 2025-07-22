<section class="grades-section">
    <h2>Minhas Notas</h2>
    <div class="grades-grid">
        <?php if (empty($notas_agrupadas)): ?>
            <p>Ainda não há notas para exibir.</p>
        <?php else: ?>
            <?php foreach ($notas_agrupadas as $disciplina => $notas): ?>
                <div class="grade-card">
                    <h3><?php echo htmlspecialchars($disciplina); ?></h3>
                    <ul>
                        <?php foreach ($notas as $nota_item): ?>
                            <li>
                                <span><?php echo htmlspecialchars($nota_item['tipo_avaliacao']); ?></span>
                                <span class="grade-value"><?php echo number_format($nota_item['nota'], 2, ',', '.'); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>