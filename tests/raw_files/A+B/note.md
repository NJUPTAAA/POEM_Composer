**Q:** Where are the input and the output? 

**A:** Your program shall always read input from stdin (Standard Input) and write output to stdout (Standard Output). For example, you can use `scanf` in C or `cin` in C++ to read from stdin, and use `printf` in C or `cout` in C++ to write to stdout. 

You shall not output any extra data to standard output other than that required by the problem, otherwise you will get a **`Wrong Answer`**. 

User programs are not allowed to open and read from\/write to files. You will get a **`Runtime Error`** or a **`Wrong Answer`** if you try to do so. 

Here is a sample solution using `C++\/G++` : 

```cpp
#include <iostream>

using namespace std;

int main()
{
    int a,b;
    cin >> a >> b;
    cout << a+b << endl;
    return 0;
}
```

It's important that the return type of `main()` must be int when you use `G++\/GCC`, or you may get compile error. 

Here is a sample solution using `C\/GCC` : 

```c
#include <stdio.h>

int main()
{
    int a,b;
    scanf(\"%d %d\",&a, &b);
    printf(\"%d\\n\",a+b);
    return 0;
}
```

Here is a sample solution using `Java` : 

```java
import java.io.*;
import java.util.*;
public class Main
{
    public static void main(String args[]) throws Exception
    {
        Scanner cin=new Scanner(System.in);
        int a=cin.nextInt(),b=cin.nextInt();
        System.out.println(a+b);
    }
}
```

Things may be quite messy with Python and frankly I don't like it but... Anyway, here is a sample solution using `Python 3` : 

```python
print(sum(int(x) for x in input().split(' ')))
```

Here is a sample solution using `Python 2` : 

```python
print sum(int(x) for x in raw_input().split(' '))
```