<?php

function isCircle($matrix, $activePixels) {
    // Проверяем, является ли матрица квадратной
    if (count($matrix) != count($matrix[0])) {
        return false;
    }

    // Проверяем горизонтальную симметрию
    if (array_reverse($matrix) != $matrix) {
        return false;
    }

    // Проверяем вертикальную симметрию
    $mirroredMatrix = [];
    foreach ($matrix as $line) {
        $mirroredMatrix[] = array_reverse($line);
    }
    if ($matrix != $mirroredMatrix) {
        return false;
    }

    // Проверяем, что матрица не полностью заполнена
    $matrixSymbolsCount = count($matrix, COUNT_RECURSIVE) - count($matrix);
    if ($matrixSymbolsCount == $activePixels) {
        return false;
    }

    return true;
}

function isSquare($matrix) {
    $n = count($matrix);
    $m = count($matrix[0]);

    // Проверяем, является ли матрица квадратной
    if ($n != $m) {
        return false;
    }

    // Проверяем, что матрица симметрична относительно диагонали
    for ($i = 0; $i < $n; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {
            if ($matrix[$i][$j] != $matrix[$j][$i]) {
                return false;
            }
        }
    }

    return true;
}

function findFigure($matrix, $xSize, $ySize) {
    // Находим первую и последнюю непустые строки
    $firstContent = 0;
    $lastContent = $ySize - 1;
    for ($line = 0; $line < $ySize; $line++) {
        if (array_sum($matrix[$line]) > 0) {
            $firstContent = $line;
            break;
        }
    }
    for ($line = $ySize - 1; $line >= $firstContent; $line--) {
        if (array_sum($matrix[$line]) > 0) {
            $lastContent = $line;
            break;
        }
    }

    // Обрезаем матрицу по строкам
    $matrix = array_slice($matrix, $firstContent, $lastContent - $firstContent + 1);

    // Находим первый и последний непустые столбцы
    $firstContent = 0;
    $lastContent = $xSize - 1;
    for ($column = 0; $column < $xSize; $column++) {
        $columnSum = 0;
        for ($row = 0; $row < count($matrix); $row++) {
            $columnSum += $matrix[$row][$column];
        }
        if ($columnSum > 0) {
            $firstContent = $column;
            break;
        }
    }
    for ($column = $xSize - 1; $column >= $firstContent; $column--) {
        $columnSum = 0;
        for ($row = 0; $row < count($matrix); $row++) {
            $columnSum += $matrix[$row][$column];
        }
        if ($columnSum > 0) {
            $lastContent = $column;
            break;
        }
    }

    // Обрезаем матрицу по столбцам
    for ($line = 0; $line < count($matrix); $line++) {
        $matrix[$line] = array_slice($matrix[$line], $firstContent, $lastContent - $firstContent + 1);
    }

    return $matrix;
}

// Получаем размеры изображения
fscanf(STDIN, "%d %d\n", $xSize, $ySize);

// Создаем матрицу изображения
$matrix = [];
$blackPixels = 0;
for ($i = 0; $i < $ySize; $i++) {
    $line = trim(fgets(STDIN));
    $matrix[$i] = explode(" ", $line);
    $blackPixels += array_sum($matrix[$i]);
}

// Обрезаем лишние строки и столбцы матрицы
$matrix = findFigure($matrix, $xSize, $ySize);

// Определяем фигуру
if (isCircle($matrix, $blackPixels)) {
    echo "circle";
} elseif (isSquare($matrix)) {
    echo "square";
} else {
    echo "triangle";
}

?>