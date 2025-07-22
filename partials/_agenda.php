<section class="schedule-section">
    <h2>Agenda Escolar</h2>
    <div class="schedule-list">
        <?php foreach ($eventos as $evento): ?>
            <div class="schedule-item schedule-type-<?php echo htmlspecialchars($evento['tipo']); ?>">
                <div class="schedule-date">
                    <span class="day"><?php echo date('d', strtotime($evento['data_evento'])); ?></span>
                    <span class="month"><?php echo date('M', strtotime($evento['data_evento'])); ?></span>
                </div>
                <div class="schedule-info">
                    <h4><?php echo htmlspecialchars($evento['titulo']); ?></h4>
                    <p>
                        <?php if ($evento['disciplina']): ?>
                            <span><?php echo htmlspecialchars($evento['disciplina']); ?></span>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="schedule-type-badge">
                    <?php echo htmlspecialchars(ucfirst($evento['tipo'])); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>