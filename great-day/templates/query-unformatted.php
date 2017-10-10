<?php
/*
 * Note: For post queries, the post content (compete or excerpt) will appear
 * as the only field within a row.
 *
 * $style - field style
 * $rows - a processed array of rows fields and classes
 * $query_details - other query details
 */
?> 
	<?php foreach ( $rows as $row ): ?>
			<?php if ( $row['fields'] ) : ?>
				<?php foreach ( $row['fields'] as $field ): ?>
					<?php if ( isset( $field['output'] ) ): ?>
							<?php print $field['output']; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
	<?php endforeach; ?>