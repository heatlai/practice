def tree(level):
    footer = level - 2
    footerSpace = footer - 1
    spaces = footer - 1
    step = 2
    stars = 1
    for i in range(1, level + 1):
        if i <= footer:
            print(' ' * spaces + '*' * stars)
            spaces -= 1
            stars += step

        if i > footer:
            print(' ' * footerSpace + '*')

tree(10)
