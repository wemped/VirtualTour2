package com.example.wemped.virtualtourskeleton;

import android.app.ActionBar;
import android.graphics.Color;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentTabHost;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TabHost;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

/*Our TabHost, creates a tab for each map.*/

public class TabHostFragment extends Fragment{
    private FragmentTabHost tabHost;
    private Map[] maps = null;

    public TabHostFragment(Map[] maps){
        this.maps = maps;
    }

    public TabHostFragment(){
        this.maps = Globals.getMaps();
    }


    @Override
    public View onCreateView(LayoutInflater inflater,ViewGroup container,Bundle savedInstanceState){
        this.tabHost = new FragmentTabHost(getActivity());
        //tabHost.setBackgroundColor(Color.parseColor("#006B3F"));
        tabHost.setOnTabChangedListener(new TabHost.OnTabChangeListener() {
            @Override
            public void onTabChanged(String s) {
                ((MainActivity)getActivity()).tabChange(s);
            }
        });
        int length = this.maps.length;
        this.tabHost.setup(getActivity(),getChildFragmentManager(),R.id.frag_tab_host);
        for (int i=0;i<length;i++){
            /*Pass data to the tab by adding it to this bundle*/
            Bundle tabBundle = new Bundle();
            tabBundle.putInt("TAB_MAP_ID", this.maps[i].getMapId());
            tabBundle.putInt("TAB_ID", i);
            tabBundle.putString("TAB_ITEM_NAME", this.maps[i].getMapDescription());

            this.tabHost.addTab(this.tabHost.newTabSpec(this.maps[i].getMapDescription()).setIndicator(this.maps[i].getMapDescription()),TabFragment.class,tabBundle);
        }
        this.tabHost.setCurrentTab(0);
        return this.tabHost;
    }

    @Override
    public void onDestroyView(){
        super.onDestroyView();
        tabHost = null;
    }
}
