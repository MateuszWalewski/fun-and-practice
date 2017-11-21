#ifndef ARRAYSORTERFACTORY_H
#define ARRAYSORTERFACTORY_H

#include <iostream>
#include <memory>
#include "ArraySorter.h"

using namespace std;


class ArraySorterFactory {
public:
    ArraySorterFactory();
	enum ArraySorterType{
		SelectionSort,
		InsertionSort,
		BubbleSort,
		MergeSort,
		QuickSort
	};

	static unique_ptr<ArraySorter> createArraySorter(ArraySorterType, int, int []);



};
#endif
