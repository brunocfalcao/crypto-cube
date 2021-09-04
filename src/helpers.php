<?php

function milliseconds(int $milliseconds = null, string $date = null)
{
    // Returns the datetime given the milliseconds.
    if ($milliseconds) {
        return date('Y-m-d H:i:s', $milliseconds / 1000);
    }

    // Returns the milliseconds given the datetime.
    if ($date) {
        return 1000 * strtotime($date);
    }

    // Returns the milliseconds of now.
    return (int) (now()->timestamp.str_pad(now()->milli, 3, '0', STR_PAD_LEFT));
}
